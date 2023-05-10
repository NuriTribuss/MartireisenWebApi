<?php

namespace Application\Api\Booking\Tour;

use Carbon\Carbon;
use Core\Base\Webservice;
use Helper\Input;
use Model\Tour\Tour as Model;
use Model\Tour\Type;
use Model\Tour\Age;
use Model\TourView;
use Model\Link\Link;
use Model\Localization\Language;
use Model\Tour\TourTranslation;

class Tour extends Webservice
{

    private $linkModel = null;

    public function __construct()
    {
        parent::__construct();

        $this->linkModel = new Link();
        $this->linkModel->setType('tour');
    }

    public function get()
    {

        try {

            $model = $this->build(Model::whereRaw('1 = 1'));
            $pagination = [
                'total' => $model->count(),
                'page' => \Helper\Input::get('page', 1)
            ];

            $skip = $pagination['page'] == 1 ? 0 : (($pagination['page'] - 1) * $this->limit);
            $data = $model->with(['translate' => function ($q) {
                $q->where('language', $this->language);
            }])->skip($skip)->take($this->limit)->get();

            $tours = [];
            if (Input::get('ssr') != 1) {
                $tours = $data->toArray();
            } else {
                $tourView = new TourView();
                foreach ($data->toArray() as $tour) {
                    $tours[] = $tourView->get($tour['id']);
                }
            }
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($tours)->out();

        } catch (\Exception $e) {
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }

    public function search()
    {

        try {
            $search_data = \Helper\Input::json();
            $model = $this->build(Model::whereRaw('1 = 1'));
            $pagination = [
                'total' => $model->count(),
                'page' => $search_data->page
            ];

            $sources = [];
            $distnations = [];
            $dates = [];

            $allData = $model->get();
            $allTours = [];
            $allTourView = new TourView();
            foreach ($allData->toArray() as $tr) {
                $allTours[] = $allTourView->get($tr['id']);
            }
            foreach ($allTours as $atour) {
                array_push($distnations, $atour['destination']);
                if ($atour['period'] != null) {
                    array_push($dates, $atour['period']['start_date_pretty']);
                    foreach ($atour['period']['stations'] as $st) {
                        array_push($sources, ['id' => $st['id'], 'station' => $st['station']]);
                    }
                }
            }

            $sources = array_unique($sources, SORT_REGULAR);
            $distnations = array_unique($distnations, SORT_REGULAR);
            $dates = array_unique($dates, SORT_REGULAR);

            $skip = $pagination['page'] == 1 ? 0 : (($pagination['page'] - 1) * $this->limit);

            if ($search_data->source)
                $model = $model->whereHas('periods', function ($q) use ($search_data) {
                    $q->with('stations')->whereHas('stations',function ($qq) use($search_data){
                        $qq->where('id',$search_data->source);
                    });
                });

            if ($search_data->distnation)
                $model = $model->where('destination',$search_data->distnation);

            if ($search_data->date)
                $model = $model->with('periods')->whereHas('periods', function ($q) use ($search_data) {
                    $q->where('start_date','>=',Carbon::createFromFormat('d.m.Y',$search_data->date)->startOfDay()->timestamp)->where('start_date','<',Carbon::createFromFormat('d.m.Y',$search_data->date)->endOfDay()->timestamp);
                });

            $data = $model->with(['translate' => function ($q) {
                $q->where('language', $this->language);
            }])->skip($skip)->take($this->limit)->get();


            $tours = [];
            if (Input::get('ssr') != 1) {
                $tours = $data->toArray();
            } else {
                $tourView = new TourView();
                foreach ($data->toArray() as $tour) {
                    $tours[] = $tourView->get($tour['id']);
                }
            }
            $result = [
                'tours' => $tours,
                'sources' => $sources,
                'distnations' => $distnations,
                'dates' => $dates
            ];
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($result)->out();

        } catch (\Exception $e) {
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }

    public function show($id = 0)
    {

        if (empty((int)$id)) {
            $this->response->out();
        }

        $return = NULL;
        $record = Model::find($id);

        if ($record != NULL) {

            $return = $record->toArray();
            $return['translate'] = $this->getLanguageContent($id);
            if (!empty($return['type'])) {
                $return['type'] = explode(';', $return['type']);
            } else {
                $return['type'] = [];
            }

            if (!empty($return['age_group'])) {
                $return['age_group'] = explode(';', $return['age_group']);
            } else {
                $return['age_group'] = [];
            }

            $this->response->setStatus(true)->setData($return)->out();
        }

        $this->response->out();

    }

    public function fetch($id = 0)
    {

        if (empty((int)$id)) {
            $this->response->out();
        }

        $tour = new \Model\TourView();
        $data = $tour->get($id);

        $this->response->setStatus(true)->setData($data)->out();

    }

    public function store()
    {

        $data = \Helper\Input::json();

        $this->validation->validate([
            'name' => 'required',
        ]);

        if ($this->validation->hasError()) {
            $this->response->setErrors($this->validation->getErrors())->out();
        }

        $this->linkModel->setUrl($data->url, $data->name);

        if ($this->linkModel->exists()) {
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }

        $record = new Model;
        $record->agreegment = isset($data->agreegment) ? (string)$data->agreegment : '';
        $record->content = isset($data->content) ? $data->content : '';
        $record->title = isset($data->title) ? $data->title : '';
        $record->departure_place = isset($data->departure_place) ? $data->departure_place : '';
        $record->destination = isset($data->destination) ? $data->destination : '';
        $record->map = isset($data->map) ? $data->map : '';
        $record->contact_phone = isset($data->contact_phone) ? $data->contact_phone : '';

        $record->country_id = isset($data->country_id) ? (int)$data->country_id : 0;
        $record->age_group = isset($data->age_group) ? implode(';', $data->age_group) : $record->age_group;
        $record->type = isset($data->type) ? implode(';', $data->type) : $record->type;
        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number : 999;
        $record->active = isset($data->active) ? (int)$data->active : 1;

        $record->seo_url = $this->linkModel->getUrl();
        $record->save();

        $pageTranslation = new \Model\Tour\TourTranslation();
        $pageTranslation->language = $this->language;
        $pageTranslation->tour_id = $record->id;
        $pageTranslation->name = $data->name;
        $pageTranslation->content = (string)$data->content;
        $pageTranslation->agreegment = (string)$data->agreegment;
        $pageTranslation->url = $this->linkModel->getUrl();
        $pageTranslation->save();

        $this->linkModel->save(['table_id' => $record->id]);

        $this->response->setStatus(true)->setData(['id' => $record->id, 'action' => 'insert'])->out();
    }

    public function update($id = 0)
    {

        $data = \Helper\Input::json();

        if ($this->validation->hasError()) {
            $this->response->setErrors($this->validation->getErrors())->out();
        }

        if ((int)$data->id > 0) {
            $id = $data->id;
        }

        $record = Model::find($id);
        if ($record == NULL) {
            $this->response->setMessage('Record Not Found')->out();
        }

        if (!empty($data->url)) {
            $this->linkModel->setUrl($data->url, $data->name);
        }

        if ($this->linkModel->exists($id)) {
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }

        $record->agreegment = isset($data->agreegment) ? $data->agreegment : $record->agreegment;
        $record->content = isset($data->content) ? $data->content : $record->content;
        $record->title = isset($data->title) ? $data->title : $record->title;
        $record->departure_place = isset($data->departure_place) ? $data->departure_place : $record->departure_place;
        $record->destination = isset($data->destination) ? $data->destination : $record->destination;
        $record->map = isset($data->map) ? $data->map : $record->map;
        $record->contact_phone = isset($data->contact_phone) ? $data->contact_phone : $record->contact_phone;

        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number : $record->sort_number;
        $record->active = isset($data->active) ? (int)$data->active : $record->active;

        $record->country_id = isset($data->country_id) ? (int)$data->country_id : $record->country_id;
        $record->age_group = isset($data->age_group) ? implode(';', $data->age_group) : $record->age_group;
        $record->type = isset($data->type) ? implode(';', $data->type) : $record->type;
        $record->save();

        $pageTranslation = TourTranslation::where(['tour_id' => $id, 'language' => $this->language])->first();
        if ($pageTranslation == NULL) {
            $pageTranslation = new TourTranslation();
            $pageTranslation->tour_id = $record->id;
        }

        $pageTranslation->language = $this->language;
        $pageTranslation->name = isset($data->name) ? $data->name : $pageTranslation->name;
        $pageTranslation->content = isset($data->content) ? $data->content : $pageTranslation->content;
        $pageTranslation->agreegment = isset($data->agreegment) ? $data->agreegment : $pageTranslation->agreegment;
        $pageTranslation->url = $this->linkModel->getUrl() == NULL ? $pageTranslation->url : $this->linkModel->getUrl();
        $pageTranslation->save();

        $this->linkModel->update(['table_id' => $record->id]);

        $this->response->setStatus(true)->out();
    }

    public function translate($pageId = 0)
    {

        $data = \Helper\Input::json();

        $this->validation->validate([
            'name' => 'required',
            'language' => 'required',
        ]);

        if ($this->validation->hasError()) {
            $this->response->setErrors($this->validation->getErrors())->out();
        }

        $record = Model::find($pageId);

        if ($record == NULL) {
            $this->response->setMessage('Record Not Found')->out();
        }

        if (strlen($data->language) != 2) {
            $this->response->setMessage('Language Not Found')->out();
        }

        $this->linkModel->setLanguage($data->language);
        $this->linkModel->setUrl($data->url, $data->name);

        if ($this->linkModel->exists($pageId, $data->language)) {
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }

        $pageTranslation = TourTranslation::where(['tour_id' => $pageId, 'language' => $data->language])->first();

        if ($pageTranslation == NULL) {
            $pageTranslation = new TourTranslation();
            $pageTranslation->tour_id = $record->id;
            $pageTranslation->language = $data->language;
        }

        $pageTranslation->name = isset($data->name) ? $data->name : $pageTranslation->name;
        $pageTranslation->content = isset($data->content) ? $data->content : $pageTranslation->content;
        $pageTranslation->agreegment = isset($data->agreegment) ? $data->agreegment : $pageTranslation->agreegment;
        $pageTranslation->url = $this->linkModel->getUrl() == NULL ? $pageTranslation->url : $this->linkModel->getUrl();
        $pageTranslation->save();

        $this->linkModel->update(['table_id' => $record->id], true);
        $this->response->setStatus(true)->out();

    }

    public function destroy($id = 0)
    {

        $record = Model::find($id);
        if ($record == NULL) {
            $this->response->setMessage('Record Not Found')->out();
        }

        $record->delete();
        \Model\Tour\Period::where('tour_id', $id)->delete();
        TourTranslation::where('tour_id', $id)->delete();

        $this->linkModel->delete(['table_id' => $id]);
        $this->response->setStatus(true)->out();
    }

    private function filter($entity)
    {

        $params = $_GET;

        if (!empty($params['code'])) {
            $entity = $entity->where('code', 'LIKE', $params['code'] . '%');
        }

        if (!empty($params['email'])) {
            $entity = $entity->where('email', 'LIKE', $params['email'] . '%');
        }

        if (!empty($params['name'])) {
            $entity = $entity->where('name', 'LIKE', $params['name'] . '%');
        }

        if (!empty($params['surname'])) {
            $entity = $entity->where('surname', 'LIKE', $params['surname'] . '%');
        }

        // 2020-01-25 00:00:00

        if (!empty($params['created_at'])) {
            if (isset($params['created_at']['min'])) {
                $entity = $entity->where('created_at', '>=', $params['created_at']['min']);
            }
            if (isset($params['created_at']['max'])) {
                $entity = $entity->where('created_at', '<=', $params['created_at']['max']);
            }
        }

        return $entity;
    }

    // LANGUAGE
    public function getLanguageContent($id)
    {

        $return = [];
        $languages = Language::all();

        foreach ($languages as $language) {

            $add = array('language' => $language->code, 'name' => '', 'agreegment' => '', 'url' => '', 'content' => '', 'default' => $language->code == $this->language ? 1 : 0);
            $translate = TourTranslation::where(['tour_id' => $id, 'language' => $language->code])->first();

            if ($translate != NULL) {
                $add['name'] = $translate->name;
                $add['content'] = $translate->content;
                $add['url'] = $translate->url;
                $add['agreegment'] = $translate->agreegment;
            }

            array_push($return, $add);
        }

        return $return;
    }

    public function setMainImage($id)
    {

        if (isset($_FILES['file'])) {

            $uploader = new \Core\Upload\Upload($_FILES['file']);

            $uploader->allowed = array('image/*');
            $uploader->file_new_name_body = 'image_main';
            $uploader->image_convert = 'jpg';
            $uploader->file_overwrite = true;
            $process = $uploader->upload('image/tours/' . $id);
            if ($process !== false) {
                $tour = Model::find($id);
                $tour->image = $process;
                $tour->save();
                $this->response->setStatus(true)->out();
            }
        }
        $this->response->setStatus(false)->out();
    }

    public function setPlanImage($id)
    {

        if (isset($_FILES['file'])) {

            $uploader = new \Core\Upload\Upload($_FILES['file']);

            $uploader->allowed = array('image/*');
            $uploader->file_new_name_body = 'image_plan';
            $uploader->image_convert = 'jpg';
            $uploader->file_overwrite = true;

            $process = $uploader->upload('image/tours/' . $id);
            if ($process !== false) {

                $tour = Model::find($id);
                $tour->tour_plan_image = $process;
                $tour->save();
                $this->response->setStatus(true)->out();
            }
        }
        $this->response->setStatus(false)->out();
    }


    public function period($tourId, $id = null, $method = null)
    {

        $period = new Period();
        $period->tourId = $tourId;
        $period->index($id, $method);
    }

    public function plan($tourId, $id = null, $method = null)
    {

        $plan = new Plan();
        $plan->tourId = $tourId;
        $plan->index($id, $method);
    }

    public function property($tourId, $id = null, $method = null)
    {

        $property = new Property();
        $property->tourId = $tourId;
        $property->index($id, $method);
    }

    public function image($tourId, $id = null, $method = null)
    {

        $image = new Image();
        $image->tourId = $tourId;
        $image->index($id, $method);
    }

    public function video($tourId, $id = null, $method = null)
    {

        $image = new Video();
        $image->tourId = $tourId;
        $image->index($id, $method);
    }

}
