<?php

namespace Application\Api\Engine;

use Model\Providers\Connector;
use Core\Base\Service;

class Hotel extends Service {
            
    private $connector;
    
    function __construct() {
        parent::__construct();
        $this->connector = new Connector();
    }
    
    public function get() {
        
        $this->connector->setFilter();
        $result = $this->connector->hotels();
        $this->response->setData($result)->setStatus(!$result['error'])->out();
    }

    public function listByGiata() {

        $result = $this->connector->hotelByGiata();
        $this->response->setData($result)->setStatus(!$result['error'])->out();

    }

    public function top() {
        
        $this->connector->setFilter();
        $result = $this->connector->hotels(true);
        
        $this->response->setData($result)->setStatus(!$result['error'])->out();
    }
    
    public function detail($id) {
       // tourOperatorList: "ALL,BIG,ETI,FLYD,FTI,ITS,JAHN,MWR,NEC,NER,SLR,SLRD,TUID,X5VF,XALL,XBIG,XDER,XETI,XFTI,XJAH,5VF,ATI,DER,XMWR,TUI,XTUI,BCH,ADAC,AIR,ALD,AME,ATID,ATK,BU,BYE,CBM,CFI,DERT,DTA,GULE,HERM,ITSB,ITSC,ITSX,JAHA,OGE,OLI,TIP,TIPD,TUIA,XITS,ANEX,XANE,1AV,ATIS,ATOU,AWT,BAV,BDV,BENX,BUM,BXCH,CDA,CDHB,CDTA,CHR,COR,CPK,DANS,DES,ECC,ELVI,ERV,ETD,FALK,FER,FIT,FLT,FOX,FTV,FUV,HCON,HEX,HMR,HTH,HUC,ICC,IHOM,ITT,JANA,JT,KAE,LMX,LMXI,MON,MPR,NOSO,OGO,PALH,PALM,PHX,RIVA,RSD,SCAR,SCR,SIT,SNOW,SPOT,STT,TRAL,TREX,TUIS,TVR,VFLY,VTO,VTOI,WOL,XOLI,XPOD,XPUR"

        $this->connector->setFilter();
        $result = $this->connector->hotelDetail($id);
        
        $this->response->setData($result)->setStatus(!$result['error'])->out();
    }
    
    public function reviews($id) {
        
        $result = $this->connector->reviews($id);
        $this->response->setData($result)->setStatus(!$result['error'])->out();
    }
    
}
