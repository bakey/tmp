<?php
	class Emailer extends CModel{
		
		private $allAddress = array(
			'no-reply'=>array(
				'address' => 'no-reply@libedu.com',
				'username' => 'no-reply@libedu.com',
				'alias' => 'LibEDU 励博教育',
				'password' => '123456a',
			),
			'service'=>array(
				'address' => 'service@libedu.com',
				'username' => 'service@libedu.com',
				'alias' => 'LibEDU Corporation',
				'password' => '',
			),
			'admin'=>array(
				'address' => 'admin@libedu.com',
				'username' => 'admin@libedu.com',
				'alias' => 'LibEDU Corporation',
				'password' => '',
			),
		);

		private $data = array();

		private $fromAddress;
		private $fromAlias;
		private $toAddress;
		private $toAlias;
		private $mailUsername;
		private $mailPassword;
		private $msgTemplate;
		private $msgBody = array();
		private $msgSubject = '';
		private $serverAddress = 'smtp.exmail.qq.com';
		private $serverPort = 465;
		private $serverRequireSSL = true;
		
		private $transport;

		private $isForeignAddress = false;
		private $isSetMsgBody = false;
		private $isSetMsgSubject = false;
		private $isMsgHtml = true;
		
		
		public function attributeNames(){
			return array('a','b');
		}

		public function setFromAddress($para){
			$this->fromAddress = $para;	
		}

		public function setFromAlias($para){
			$this->fromAlias = $para;	
		}

		public function setToAddress($para){
			$this->toAddress = $para;	
		}

		public function setToAlias($para){
			$this->toAlias = $para;	
		}

		public function setMailUsername($para){
			$this->mailUsername = $para;	
		}

		public function setMailPassword($para){
			$this->mailPassword = $para;	
		}

		public function setMsgTemplate($para){
			$this->msgTemplate = $para;	
		}

		public function setMsgSubject($para){
			$this->msgSubject = $para;
			$this->isSetMsgSubject = true;	
		}

		public function setMsgBody($para){
			$this->msgBody = $para;	
			$this->isSetMsgBody = true;
		}

		public function setServerAddress($para){
			$this->serverAddress = $para;	
		}

		public function setServerPort($para){
			$this->serverPort = $para;	
		}

		public function setMsgType($para){
			if($para == 'text'){
				$this->isMsgHtml = false;
			}else{
				$this->isMsgHtml = true;
			}
		}


		public function __construct($sendToAddres='', $sendToAlias='', $sendFromAddress = 'no-reply', $sendFromAlias = '', $sendFromUsername = '', $sendFromPassword = '',  $mailTemplate = 'notification', $mailSubject='', $mailMsgBody= array()){
			
			//set necessary info & var
			if(isset($this->allAddress[$sendFromAddress])){
				$this->fromAddress = $this->allAddress[$sendFromAddress]['address'];
				$this->mailUsername = $this->allAddress[$sendFromAddress]['username'];
				$this->mailPassword = $this->allAddress[$sendFromAddress]['password'];
				$this->fromAlias = $this->allAddress[$sendFromAddress]['alias'];
			}else{
				$this->isForeignAddress = true;
				$this->fromAddress = $sendFromAddress;
				$this->fromAlias = $sendFromAlias;
				$this->mailUsername = $sendFromUsername;
				$this->mailPassword = $sendFromPassword;
			}
			if(!empty($mailMsgBody)){
				$this->isSetMsgBody = true;
			}

			if($mailSubject != ''){
				$$this->msgSubject = $mailSubject;
			}

			$this->toAddress = $sendToAddres;
			$this->toAlias = $sendToAlias;
			$this->msgTemplate = $mailTemplate;
			$this->msgSubject = $mailSubject;
			$this->msgBody = $mailMsgBody;
            
			//load & init swift mailer
			$applicationPath = Yii::getPathOfAlias('webroot');
			require_once $applicationPath.'/protected/vendors/swiftmailer/classes/Swift.php';
			Yii::registerAutoloader(array('Swift','autoload'));
			require_once $applicationPath.'/protected/vendors/swiftmailer/swift_init.php';
		}

	    private function generateMsgBody(){
	    	$applicationPath = Yii::getPathOfAlias('webroot');
			include_once $applicationPath.'/protected/views/email_template/'.$this->msgTemplate.'.php';
	    	if(empty($this->msgBody)){
	    		die('Message Body Not Set');
	    	}else{
	    		return getMsgBodyFromTemplate($this->msgBody);
	    	}
	    }
	    
	    public function doSendMail(){
	    	$transport = Swift_SmtpTransport::newInstance($this->serverAddress, $this->serverPort, "ssl")
				  ->setUsername($this->mailUsername)
				  ->setPassword($this->mailPassword);
			$mailer = Swift_Mailer::newInstance($transport);
			if($this->msgSubject != ''){
				$message = Swift_Message::newInstance($this->msgSubject)
				  ->setFrom(array($this->fromAddress => $this->fromAlias))
				  ->setTo(array($this->toAddress => $this->toAlias));
			}else{
				die("Email Subject Not Set");
			}
			if($this->isMsgHtml){
				$message->setBody($this->generateMsgBody());
			}else{
				$message->setBody($this->msgBody);
			}
			if($this->isMsgHtml){
				$message->setContentType('text/html');
			}else{
				$message->setContentType('text/plain; charset=UTF-8');
			}
			$mailer->send($message);
	    }

	}

?>