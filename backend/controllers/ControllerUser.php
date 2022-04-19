<?php
require_once './tokens/middlewares/Auth.php';
require_once './controllers/Controller.php';

class ControllerUser extends Controller
{
    public function __construct($url) {
        parent::__construct();
        $this->_manager = new UserManager();
        $this->_view = new View('Home');
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'GET'):
                $this->authUser();
                if (isset($url[1])):
                    $action = $url[1];
                    if(method_exists($this, $action)):
                        $this->$action();
                    else:
                        throw new Exception('Page introuvable', 404);
                    endif; 
                else:
                    $this->setOnline(1);
                    $this->getUser();
                endif;
            else:
                throw new Exception('Page introuvable', 404);
            endif;
            $this->_view->generate($this->_returnData);
        } catch (Exception $e) {
            $this->_returnData = $this->msgErr(false,$e->getCode(),$e->getMessage());
            $this->_view->generate($this->_returnData); 
        }
    }

    // let's set user status `online`
    private function setOnline($status) {
        // if user already online
        $this->_manager->setUser(
            array('online' => $status),
            array('id' => $this->_userId)
        );
    }

    // logout user
    private function logout() {
        $this->setOnline(0);
        session_destroy();
        $this->_returnData = array(
            'success' => true,
            'status' => 200,
            'message' => 'Déconnexion réussie!'
        );
    }

    // let's auth the user 
    private function authUser() {
        $jwt_auth = new Auth(getallheaders());
        $userId = $jwt_auth->auth();
        if (isset($userId)):
            $this->_userId = (int) $userId;
        else:
            throw new Exception('Unauthorized', 401);
        endif;
    }

    // fetch user data
    private function getUser() {
        $user = $this->_manager->getUser(
            array('id' => $this->_userId)
        );

        // ENVOIE DES DONNEES
        if (isset($user)) :
            $user = $user[0];
            $this->_returnData = array(
                'success' => 1,
                'status' => 200,
                'user' => $user
            );
        endif;
    }

    private $_userId;
}