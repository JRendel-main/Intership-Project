<?php 

class CrudsController extends AppController {
    public function beforeFilter()
    {

        parent::beforeFilter();

        $this->RequestHandler->ext = 'json';

    }


    public function index() {

        $page = $this->request->query['page'] ?? 1;

        $paginatorSettings = array(
            'limit' => 25,
            'page' => $page,
            'order' => array('Crud.name' => 'ASC')
        );

        $modelName = 'Crud';
        $this->Paginator->settings = $paginatorSettings;
        $tempData = $this->Paginator->paginate($modelName);
        $paginator = $this->request->params['paging'][$modelName];

        $cruds_=array();

        foreach($tempData as $crud) {
            $cruds_[] = array(
                'id' => $crud['Crud']['id'],
                'name' => properCase($crud['Crud']['name']),
                'age' => $crud['Crud']['age'],
                'character' => $crud['Crud']['character'],
                'date_created' => date('m/d/Y', strtotime($crud['Crud']['created'])),
            );
        }

        $response = array(
            'ok' => true,
            'untransformed' => $tempData,
            'data' => $cruds_,
            'paginator' => $paginator
        );

        $this->set(array(
            'response' => $response,
            '_serialize' => array('response')
        ));
    }

    public function add() {
        if($this->Crud->save($this->request->data['Crud'])) {
            $response = array(
                'ok' => true,
                'msg' => 'Data has been saved',
                'data' => $this->request->data,
            );
        } else {
            $response = array(
                'ok' => false,
                'msg' => 'Data has not been saved',
                'data' => $this->request->data,
            );
        }


        $this->set(array(
            'response' => $response,
            '_serialize' => array('response')
        ));
    }
}