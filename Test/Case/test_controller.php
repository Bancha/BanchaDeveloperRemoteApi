<?php
    /**
     * Users Controller
     * 
     * Please make sure to don't change these comments, since the are used in Reflection tests
     * see Test/case/BanchaApitests.php
     * 
     * @author        Roland Schuetz <roland@banchaproject.com>
     */
    class UsersController {
        
        
        /**
         * Simply displays all Users in a paginated way, also supports Bancha requests. 
         * This description has to be quite long, so we can test the 
         * BanchaApi::getRemoteApiCrudDescription properly.
         * @return Array Pagination data and users
         */
        public function index() {
            $this->User->recursive = 0;
            $users = $this->paginate();														// added
            $this->set('users', $users);													// modified
            return array_merge($this->request['paging']['User'],array('records'=>$users)); 	// added
        }
        
        /**
         * view method
         *
         * @param string $id this is the id param description
         * @return void
         */
        public function view($id = null) {
            $this->User->id = $id;
            if (!$this->User->exists()) {
                throw new NotFoundException(__('Invalid user'));
            }
            $this->set('user', $this->User->read(null, $id));
            return $this->User->data;															// added
        }
        
        
        
        /**
         * add method
         *
         * @return void
         */
        public function add() {
            if ($this->request->is('post')) {
                $this->User->create();
                
                // handle avatar field uploads
                $result = $this->handleUpload('avatar');
                if(is_string($result)) {
                    return $result; // this is an error message
                }
                
                if(isset($this->request->params['isBancha']) && $this->request->params['isBancha']) return $this->User->saveFieldsAndReturn($this->request->data);	 // added
                
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been saved'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                }
            }
        }
        
        /**
         * edit method
         * Here is some description
         * 
         * @param string $id The id of the record to edit
         * @return void|Array In case of an Bancha request returns edited record data
         */
        public function edit($id = null) {
            $this->User->id = $id;
            if (!$this->User->exists()) {
                throw new NotFoundException(__('Invalid user'));
            }
            
            // handle avatar field uploads
            $result = $this->handleUpload('avatar');
            if(is_string($result)) {
                return $result; // this is an error message
            }
            
            if(isset($this->request->params['isBancha']) && $this->request->params['isBancha']) return $this->User->saveFieldsAndReturn($this->request->data);	 // added
            
            if ($this->request->is('post') || $this->request->is('put')) {
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been saved'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                }
            } else {
                $this->request->data = $this->User->read(null, $id);
            }
        }
        
        // purposefully no php docs here (for Reflection API testing)
        public function delete($id = null) {
            
            // for the samples don't allow to 
            if($id == 1) {
                if(isset($this->request->params['isBancha']) && $this->request->params['isBancha']) {
                    return array('success'=>false,'message'=>__('It is forbidden to delete record 1, since it\'s used in the form example below.'));
                } else {
                    throw new NotFoundException(__('It is forbidden to delete record 1, since it\'s used in the form example below.'));
                }
            }
            if (!$this->request->is('post')) {
                throw new MethodNotAllowedException();
            }
            $this->User->id = $id;
            if (!$this->User->exists()) {
                throw new NotFoundException(__('Invalid user'));
            }
            
            if(isset($this->request->params['isBancha']) && $this->request->params['isBancha']) return $this->User->deleteAndReturn();	 // added
            
            if ($this->User->delete()) {
                $this->Session->setFlash(__('User deleted'));
                $this->redirect(array('action'=>'index'));
            }
            $this->Session->setFlash(__('User was not deleted'));
            $this->redirect(array('action' => 'index'));
        }
        
        /**
         * 
         * @return true if successfull, otherwise an error msg
         */
        private function handleUpload($fieldName) {
            
            // only upload files when the record validates
            $this->User->set($this->request->data);
            if($this->User->validates()) {
                /*
                 * Currently Bancha saves files at a different place then 
                 * CakePHP standard forms, this should be improved
                 */
                $file = false;
                if(isset($this->request->params['isBancha']) && $this->request->params['isBancha'] && isset($_FILES[$fieldName])) {
                    $file = $_FILES[$fieldName];
                } elseif(isset($this->request->data[$fieldName])) {
                    $file = $this->request->data[$fieldName];
                }
                
                if($file) {
                    // a file was uploaded, save it
                    $result = $this->uploadFiles('img/user-avatars', array($file)); // this function is implemented in the App Controller
                    
                    // error handling
                    if(isset($result['errors']) || isset($result['nofiles'])) {
                        $error = isset($result['errors'][0]) ? $result['errors'][0] : $result['nofiles'];
                        if(!$this->request->params['isBancha']) {
                            $this->Session->setFlash($error);
                        }
                        return $error;
                    }
                    
                    // success case
                    $this->request->data['User']['avatar'] = $result['urls'][0];
                    return true;
                }
            }
        }
        
        /**
         * This custom function is just for the BanchaDevelopmerRemoteApi tool 
         * as showcase for a Controller including both CRUD and @banchaRemotable
         * methods.
         * @param string $anyParam This is the special any param.
         */
        public function anyFunction($anyParam=null) {
            return null;
        }
        
        // This should become a consistancy example, not yet used
        /**
         * fancy method needs long to answer (for consistency tests)
         * @return Integer
         */
        //    public function fancyCalculation() {
        //        sleep(5);
        //        return 2+3;
        //    }
        /**
         * fast method answer very fast (for consistency tests)
         * @return Integer
         */
        //    public function fastCalculation() {
        //        return 2+3;
        //    }
    }
