<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 24.07.14
 * Time: 21:53
 */

namespace PServerCMS\Controller;

use PServerCMS\Service;
use Zend\Mvc\Controller\AbstractActionController;

class AccountController extends AbstractActionController {
	const ErrorNameSpace = 'pserver-user-account-error';
	const SuccessNameSpace = 'pserver-user-account-success';
	protected $userService;

	public function indexAction() {

        /** @var \PServerCMS\Entity\Users $user */
        $user = $this->getUserService()->getAuthService()->getIdentity();

        $form = $this->getUserService()->getChangePwdForm();
        $elements = $form->getElements();
        foreach ($elements as $element) {
            if ($element instanceof \Zend\Form\Element) {
                $element->setValue('');
            }
        }

		$formChangeWebPwd = null;
		if($this->getUserService()->isSamePasswordOption()){
			$webPasswordForm = clone $form;
			$formChangeWebPwd = $webPasswordForm->setWhich('web');
		}

		$inGamePasswordForm = clone $form;
        $formChangeIngamePwd = $inGamePasswordForm->setWhich('ingame');

        $request = $this->getRequest();
        if(!$request->isPost()){
            return array(
				'changeWebPwdForm' => $formChangeWebPwd,
				'changeIngamePwdForm' => $formChangeIngamePwd,
				'messagesWeb' => $this->flashmessenger()->getMessagesFromNamespace(self::SuccessNameSpace. 'Web'),
				'messagesInGame' => $this->flashmessenger()->getMessagesFromNamespace(self::SuccessNameSpace. 'InGame'),
				'errorsWeb' => $this->flashmessenger()->getMessagesFromNamespace(self::ErrorNameSpace. 'Web'),
				'errorsInGame' => $this->flashmessenger()->getMessagesFromNamespace(self::ErrorNameSpace. 'InGame')
			);

        }

        $method = $this->params()->fromPost('which') == 'ingame'?'changeIngamePwd':'changeWebPwd';
        if($this->getUserService()->$method($this->params()->fromPost(), $user)){
			$successKey = self::SuccessNameSpace;
			if($this->params()->fromPost('which') == 'ingame'){
				$successKey .= 'InGame';
			}else{
				$successKey .= 'Web';
			}
            $this->flashMessenger()->setNamespace($successKey)->addMessage('Success, password changed.');
        }
        return $this->redirect()->toUrl($this->url()->fromRoute('user'));
	}

	/**
	 * @return \PServerCMS\Service\User
	 */
	protected function getUserService(){
		if (!$this->userService) {
			$this->userService = $this->getServiceLocator()->get('small_user_service');
		}

		return $this->userService;
	}
}