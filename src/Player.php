<?php
	 class Player
		{
            private $id;
			private $name;
			private $password;

			function __construct($name, $password, $id=NULL)
			{
				$this->name = $name;
				$this->password = $password;
				$this->id = $id;

			}

			function setName($name)
			{
				$this->name = $name;
			}

			function getName()
			{
				return $this->name;
			}

			function setPassword($password)
			{
				$this->password = $password;
			}

			function getPassword()
			{
				return $this->password;
			}

			function addPoint()
			{
					$this->score = $this->score + 1;

			}


	}
 ?>
