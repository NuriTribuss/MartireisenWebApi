<?php



namespace Core\Structure;

class NestedSet {

    /**
     * Database object
     * @type resource
     */
    private $database;

    /**
     * Table name
     * @type string
     */
    private $table = 'categories';

    /**
     * Constructor, defined PDO object
     * @param object $dbh
     */
    public function __construct($dbh) {
        $this->database = new database($dbh);
    }

    /**
     * Change the current table to manage tree structure
     * @param object $table table name
     */
    public function changeTable($table) {
        $this->table = $table;
    }

    /**
     * Add root to the table (for initialization only)
     */
    public function addRoot() {
        
        $sql = 'SELECT COUNT(1) AS row_count FROM ' . $this->table . ' WHERE lvl=0;';
        $query = $this->database->execute($sql);
        $result = $query->result();
        if ($result[0]->row_count != '0') {
            return false; // root exists, exit
        }
        $sql = 'INSERT INTO ' . $this->table . '(label, lft, rgt, lvl) VALUES(?, ?, ?, ?)';
        $query = $this->database->execute($sql, array('root', '1', '2', '0'));
    }

    /**
     * Add new node to the tree structure
     * @param string $label node name
     * @param int $node_parent_id parent node id
     * @return int new node id
     */
    
    public function addNode($label = '', $node_parent_id = '') {
        //if no parent define, add to root node
        if ($node_parent_id == '') {
            $sql = 'SELECT id FROM ' . $this->table . ' WHERE lvl=0';
            $query = $this->database->execute($sql);
            // check if root node exists
            if ($query->numRows() == 0) {
                $this->addRoot();
                return $this->addNode($label, $node_parent_id);
            }
            $result = $query->result();
            $node_parent_id = $result[0]->id;
        }
        //check if node_parent_id exists
        $sql = 'SELECT id, lft, rgt, lvl FROM ' . $this->table . ' WHERE id = ?';
        $query = $this->database->execute($sql, array($node_parent_id));
        if ($query->numRows() == 0) {
            return false; // no parent ?
        }
        $result = $query->result();
        $parent_lft = $result[0]->lft;
        $parent_rgt = $result[0]->rgt;
        $parent_lvl = $result[0]->lvl;
        $this->database->transStart();
        //shift the node to give some room for new node
        $sql = 'UPDATE ' . $this->table . '
			SET 
				lft = CASE
					WHEN lft > ? THEN lft + 2
					ELSE lft
				END,
				rgt = CASE
					WHEN rgt >= ? THEN rgt + 2
					ELSE rgt
				END
			WHERE
				rgt >= ?';
        $this->database->execute($sql, array($parent_rgt, $parent_rgt, $parent_rgt));
        $sql = 'INSERT INTO ' . $this->table . '(label, lft, rgt, lvl, parent_id,created_time) VALUES(?, ?, ?, ?, ?,?)';
        $this->database->execute($sql, array($label, $parent_rgt, $parent_rgt + 1, $parent_lvl + 1, $node_parent_id,time()));

        $this->database->transEnd();
        return $this->database->lastInsertId();
    }

    /**
     * Select all nodes from the table
     */
    public function selectAll() {
        $sql = 'SELECT id, label, lvl, parent_id,
			FORMAT((((rgt - lft) -1) / 2),0) AS cnt_children, 
			CASE WHEN rgt - lft > 1 THEN 1 ELSE 0 END AS is_branch
			FROM ' . $this->table . ' ORDER BY lft';
        return $this->database->execute($sql);
    }

    /**
     * Move existing node into node 2
     * @param int $node_id_1 id of node 1
     * @param int $node_id_2 id of node 2
     */
    public function addChild($node_id_1, $node_id_2) {
        if ($node_id_1 == $node_id_2) {
            return false; //same node
        }
        // check if node id 1, 2 exist
        $sql = 'SELECT id, lft, rgt, lvl FROM ' . $this->table . ' WHERE id=? OR id=?';
        $query = $this->database->execute($sql, array($node_id_1, $node_id_2));
        if ($query->numRows() != 2) {
            return false; //no node
        }
        // save the result
        $result = $query->result();
        if ($result[0]->id == $node_id_1) {
            $node1 = $result[0];
            $node2 = $result[1];
        } else {
            $node1 = $result[1];
            $node2 = $result[0];
        }
        $node1_size = $node1->rgt - $node1->lft + 1;
        $this->database->transStart();
        // temporary "remove" moving node
        $sql = 'UPDATE ' . $this->table . '
				   SET lft = 0 - lft
					  ,rgt = 0 - rgt
					  ,lvl = lvl + (?)
				 WHERE lft >= ? AND rgt <= ?';
        $this->database->execute($sql, array($node2->lvl - $node1->lvl + 1, $node1->lft, $node1->rgt));
        // decrease left / right position for current node
        $sql = 'UPDATE ' . $this->table . '
				   SET lft = lft - (?)
				 WHERE lft >= ?';
        $this->database->execute($sql, array($node1_size, $node1->lft));
        $sql = 'UPDATE ' . $this->table . '
				   SET rgt = rgt - (?)
				 WHERE rgt >= ?';
        $this->database->execute($sql, array($node1_size, $node1->rgt));
        // increase left / right position for future node
        $sql = 'UPDATE ' . $this->table . '
				   SET lft = lft + (?)
				 WHERE lft >= ?';
        $this->database->execute($sql, array($node1_size, $node2->rgt > $node1->rgt ? $node2->rgt - $node1_size : $node2->rgt));
        $sql = 'UPDATE ' . $this->table . '
				   SET rgt = rgt + (?)
				 WHERE rgt >= ?';
        $this->database->execute($sql, array($node1_size, $node2->rgt > $node1->rgt ? $node2->rgt - $node1_size : $node2->rgt));
        // move the node to new position
        $sql = 'UPDATE ' . $this->table . '
					SET
						lft = 0 - lft + (?),
						rgt = 0 - rgt + (?)
					WHERE lft <= ? AND rgt >= ?';
        $this->database->execute($sql, array(
            $node2->rgt > $node1->rgt ? $node2->rgt - $node1->rgt - 1 : $node2->rgt - $node1->rgt - 1 + $node1_size,
            $node2->rgt > $node1->rgt ? $node2->rgt - $node1->rgt - 1 : $node2->rgt - $node1->rgt - 1 + $node1_size,
            0 - $node1->lft, 0 - $node1->rgt));
        // update parent
        $sql = 'UPDATE ' . $this->table . '
					SET
						parent_id = ?
					WHERE
						id = ?';
        $this->database->execute($sql, array($node2->id, $node1->id));
        $this->database->transEnd();
    }

    /**
     * Move existing node before node 2
     * @param int $node_id_1 id of node 1
     * @param int $node_id_2 id of node 2
     */
    public function addBefore($node_id_1, $node_id_2) {
        if ($node_id_1 == $node_id_2) {
            return false; //same node
        }
        // check if node id 1, 2 exist
        $sql = 'SELECT id, lft, rgt, lvl, parent_id FROM ' . $this->table . ' WHERE id=? OR id=?';
        $query = $this->database->execute($sql, array($node_id_1, $node_id_2));
        if ($query->numRows() != 2) {
            return false; //no node
        }
        // save the result
        $result = $query->result();
        if ($result[0]->id == $node_id_1) {
            $node1 = $result[0];
            $node2 = $result[1];
        } else {
            $node1 = $result[1];
            $node2 = $result[0];
        }
        $this->database->transStart();
        // if not in same level, put it in same level
        if ($node1->lvl != $node2->lvl || $node1->parent_id != $node2->parent_id) {
            $this->addChild($node_id_1, $node2->parent_id);
            return $this->addBefore($node_id_1, $node_id_2);
        }
        // same level, put node 1 before node 2
        $node1_size = $node1->rgt - $node1->lft + 1;
        $node2_size = $node2->rgt - $node1->lft + 1;
        // temporary "remove" moving node
        $sql = 'UPDATE ' . $this->table . '
			   SET lft = 0 - lft
				  ,rgt = 0 - rgt
			 WHERE lft >= ? AND rgt <= ?';
        $this->database->execute($sql, array($node1->lft, $node1->rgt));

        if ($node1->lft > $node2->lft) { //move left
            //shift the node to right to give some room
            $sql = 'UPDATE ' . $this->table . ' 				
				   SET lft = lft + ?
					  ,rgt = rgt + ?
				 WHERE lft >= ? AND rgt <= ?';
            $this->database->execute($sql, array($node1_size, $node1_size, $node2->lft, $node1->lft));
            //move back the node1
            $sql = 'UPDATE ' . $this->table . ' 				
				   SET lft = 0 - lft - ?
					  ,rgt = 0 - rgt - ?
				 WHERE lft <= ? AND rgt >= ?';
            $this->database->execute($sql, array($node1->lft - $node2->lft, $node1->lft - $node2->lft, 0 - $node1->lft, 0 - $node1->rgt));
        } else {
            //shift the node to left to give some room
            $sql = 'UPDATE ' . $this->table . ' 				
				   SET lft = lft - ?
					  ,rgt = rgt - ?
				 WHERE lft >= ? AND rgt < ?';
            $this->database->execute($sql, array($node1_size, $node1_size, $node1->rgt, $node2->lft));
            //move back the node1
            $sql = 'UPDATE ' . $this->table . ' 				
				   SET lft = 0 - lft + ?
					  ,rgt = 0 - rgt + ?
				 WHERE lft <= ? AND rgt >= ?';
            $this->database->execute($sql, array($node2->lft - $node1->rgt - 1, $node2->lft - $node1->rgt - 1, 0 - $node1->lft, 0 - $node1->rgt));
        }
        $this->database->transEnd();
    }

    /**
     * Move existing node after node 2
     * @param int $node_id_1 id of node 1
     * @param int $node_id_2 id of node 2
     */
    public function addAfter($node_id_1, $node_id_2) {
        if ($node_id_1 == $node_id_2) {
            return false; //same node
        }
        // check if node id 1, 2 exist
        $sql = 'SELECT id, lft, rgt, lvl, parent_id FROM ' . $this->table . ' WHERE id=? OR id=?';
        $query = $this->database->execute($sql, array($node_id_1, $node_id_2));
        if ($query->numRows() != 2) {
            return false; //no node
        }
        // save the result
        $result = $query->result();
        if ($result[0]->id == $node_id_1) {
            $node1 = $result[0];
            $node2 = $result[1];
        } else {
            $node1 = $result[1];
            $node2 = $result[0];
        }
        $this->database->transStart();
        // if not in same level, put it in same level
        if ($node1->lvl != $node2->lvl || $node1->parent_id != $node2->parent_id) {
            $this->addChild($node_id_1, $node2->parent_id);
            return $this->addAfter($node_id_1, $node_id_2);
        }
        // same level, put node 1 before node 2
        $node1_size = $node1->rgt - $node1->lft + 1;
        $node2_size = $node2->rgt - $node1->lft + 1;
        // temporary "remove" moving node
        $sql = 'UPDATE ' . $this->table . ' 			
			   SET lft = 0 - lft
				  ,rgt = 0 - rgt
			 WHERE lft >= ? AND rgt <= ?';
        $this->database->execute($sql, array($node1->lft, $node1->rgt));

        if ($node1->lft > $node2->lft) { //move left
            //shift the node to right to give some room
            $sql = 'UPDATE ' . $this->table . ' 				
				   SET lft = lft + ?
					  ,rgt = rgt + ?
				 WHERE lft > ? AND rgt <= ?';
            $this->database->execute($sql, array($node1_size, $node1_size, $node2->rgt, $node1->lft));
            //move back the node1
            $sql = 'UPDATE ' . $this->table . ' 				
				   SET lft = 0 - lft - ?
					  ,rgt = 0 - rgt - ?
				 WHERE lft <= ? AND rgt >= ?';
            $this->database->execute($sql, array($node1->lft - $node2->rgt - 1, $node1->lft - $node2->rgt - 1, 0 - $node1->lft, 0 - $node1->rgt));
        } else {
            //shift the node to left to give some room
            $sql = 'UPDATE ' . $this->table . ' 				
				   SET lft = lft - ?
					  ,rgt = rgt - ?
				 WHERE lft >= ? AND rgt <= ?';
            $this->database->execute($sql, array($node1_size, $node1_size, $node1->rgt, $node2->rgt));
            //move back the node1
            $sql = 'UPDATE ' . $this->table . ' 				
				   SET lft = 0 - lft + ?
					  ,rgt = 0 - rgt + ?
				 WHERE lft <= ? AND rgt >= ?';
            $this->database->execute($sql, array($node2->rgt - $node1->rgt, $node2->rgt - $node1->rgt, 0 - $node1->lft, 0 - $node1->rgt));
        }
        $this->database->transEnd();
    }

    /**
     * Delete existing node
     * @param int $node_id id of node
     */
    public function deleteNode($node_id) {
        $sql = 'SELECT id, lft, rgt, lvl FROM ' . $this->table . ' WHERE id=?';
        $query = $this->database->execute($sql, $node_id);
        if ($query->numRows() == 0) {
            return false; //no node
        }
        $result = $query->result();
        $lft = $result[0]->lft;
        $rgt = $result[0]->rgt;
        $lvl = $result[0]->lvl;

        $this->database->transStart();
        // remove parent first
        $sql = 'UPDATE ' . $this->table . ' 				
					SET parent_id = NULL
					WHERE lft >= ? AND rgt <= ?';
        $this->database->execute($sql, array($lft, $rgt));
        // delete nodes
        /*
          $sql = 'DELETE *
          FROM ' . $this->table . '
          WHERE lft >= ?
          AND rgt <= ?';
          $this->database->execute($sql, array($lft, $rgt));
         */
        $sql = 'DELETE 
				  FROM ' . $this->table . ' 			  
				 WHERE parent_id IS NULL AND lvl <> 0';
        $this->database->execute($sql);
        $node_tmp = $rgt - $lft + 1;
        // shift other node to correct position
        $sql = 'UPDATE ' . $this->table . ' 				
				   SET lft = CASE WHEN lft > ? THEN lft - ? ELSE lft END,
					  rgt = CASE WHEN rgt >= ? THEN rgt - ? ELSE rgt END
				 WHERE rgt >= ?';
        $this->database->execute($sql, array($lft, $node_tmp, $rgt, $node_tmp, $rgt));
        $this->database->transEnd();
    }

}

class database {
    
    private $dh;
    private $trans;
    public function __construct(\PDO $dbh) {
        $this->dh = $dbh;
        $this->trans = false;
    }
    public function lastInsertId() {
        return $this->dh->lastInsertId();
    }
    public function transStart() {
        if($this->trans) return;
        $this->trans = true;
        $this->dh->beginTransaction();
    }
    public function transEnd() {
        $this->trans = false;
        $this->dh->commit();
    }
    
    public function execute($sql, $placeholders = array()) {
        $stmt = new statement($this->dh);
        return $stmt->query($sql, $placeholders);
    }
}

class statement {
    
    private $dh;
    private $stmt;
    private $result;
    private $result_array;
    public function __construct($dh) {
            $this->dh = $dh;
    }
    public function query($sql, $placeholders = array()) {
        if(count($placeholders) == 0)
            $this->stmt = $this->dh->query($sql);
        else {
            if(!is_array($placeholders)) $placeholders = array($placeholders);
            $this->stmt = $this->dh->prepare($sql);
            $this->stmt->execute($placeholders);
        }
        return $this;
    }
    public function result($array = false) {
        if(!$array && $this->result != null) return $this->result;
        if($array && $this->result_array != null) return $this->result_array;
        if($this->stmt != null) {
            if(!$array) {
                $this->result = $this->stmt->fetchAll(\PDO::FETCH_OBJ);
                return $this->result;
            }
            else {
                $this->result_array = $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $this->result_array;
            }
        }
        return array();
    }
    public function numRows() {
        if($this->stmt != null) return $this->stmt->rowCount();
        return 0;
    }
}