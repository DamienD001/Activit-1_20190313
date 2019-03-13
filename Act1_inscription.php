<?php

	const DB_HOST="localhost";
	const DB_USER="root";
	const DB_PWD="";

	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

	try {
		$pdo = new PDO('mysql:host='.DB_HOST, DB_USER, DB_PWD,$options);
	}catch(PDOException $e){
        $message="erreur de connexion";
    }

    //creer la base et la table si elles n'existent pas
    creationTable($pdo);

    //verification des champs de formulaire
    if (verificationFormulaire($pdo)){
    	if (verifAdrMailBDD($pdo,$_POST['adrMail'])){
    		inscription($pdo);
    		echo "vous êtes inscrit";
    	}else{
    		echo "Cette adresse existe déja";
    	}
    	
    }else{
    	echo 'erreur d\'ecriture';
    }

	function creationTable($pdo){
		$requete =<<<SQL
		    CREATE DATABASE IF NOT EXISTS NFA021_ACT1 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		    USE NFA021_ACT1;
		    CREATE TABLE IF NOT EXISTS COMPTE_USER (
		        USER_nom varchar(100) NOT NULL,
		        USER_prenom varchar(100) NOT NULL,
		        USER_fonction varchar(100) NOT NULL,
		        USER_adresseMail varchar(100) NOT NULL PRIMARY KEY,
		        USER_dateNaissance DATE NOT NULL,
		        USER_motDePasse varchar(100) NOT NULL
		    ) ENGINE=innoDB;
SQL;

	    $pdo->prepare($requete)->execute();
	}

	function verificationFormulaire():bool{
		if(isset($_POST['nom']) && $_POST['nom']!="" && ctype_alnum($_POST['nom'])){
			$OK_nom=true;
			echo 'nom : '.$OK_nom." ".$_POST['nom']."<br>";
		}else{
			echo 'caractères incorrects';
			$OK_nom=false;
		}
		
		if(isset($_POST['prenom']) && $_POST['prenom']!="" && ctype_alnum($_POST['prenom'])){
			$OK_prenom=true;
			echo 'prenom : '.$OK_prenom." ".$_POST['prenom']."<br>";
		}
		
		if(isset($_POST['fonction']) && $_POST['fonction']!="" && ctype_alpha($_POST['fonction'])){
			$OK_fonction=true;
			echo 'fonction : '.$OK_fonction." ".$_POST['fonction']."<br>";
		}
		
		if(isset($_POST['adrMail']) && $_POST['adrMail']!=""){
			$OK_adrMail=true;
			echo 'adresse : '.$OK_adrMail." ".$_POST['adrMail']."<br>";	
		}
		
		if(isset($_POST['dateNaiss']) && $_POST['dateNaiss']!=""){
			$tabDate=explode("/",$_POST['dateNaiss']);
			$OK_dateNaiss=true;
			echo 'date : '.$OK_dateNaiss." ".$_POST['dateNaiss']." / ".$tabDate[0]."-".$tabDate[1]."-".$tabDate[2]."<br>";
		}
		
		if(isset($_POST['pwd']) && $_POST['pwd']!=""){
			$OK_pwd=true;
			echo 'pwd : '.$OK_pwd." ".$_POST['pwd']."<br>";
		}

		if(isset($_POST['repeatPwd'])){
			if ($_POST['repeatPwd']==$_POST['pwd']){
				$OK_repeatPwd=true;
				echo 'repeatPwd : '.$OK_repeatPwd." ".$_POST['repeatPwd']."<br>";
			}else{
				echo 'mot de passe different';
			}
		}else{
			echo 'confirmer le mot de passe';
		}


		return ($OK_nom && $OK_prenom && $OK_fonction && $OK_adrMail && $OK_dateNaiss && $OK_pwd && $OK_repeatPwd);
	}

	function formatDateForm(){
		$tabDate=explode("/",$_POST['dateNaiss']);
		return $tabDate[2]."-".$tabDate[1]."-".$tabDate[0];
	}


	function inscription($pdo){
		$tabInfos=array($_POST['nom'],$_POST['prenom'],$_POST['fonction'],$_POST['adrMail'],$_POST['dateNaiss'],$_POST['pwd']);
		$nom=$pdo->quote($tabInfos[0]);
		$prenom=$pdo->quote($tabInfos[1]);
		$fonction=$pdo->quote($tabInfos[2]);
		$adr=$pdo->quote($tabInfos[3]);
		$dt=$pdo->quote(formatDateForm($tabInfos[4]));
		$pwd=$pdo->quote($tabInfos[5]);

		$requete=<<<SQL
			USE NFA021_ACT1;
            INSERT INTO COMPTE_USER (USER_nom, USER_prenom, USER_fonction,USER_adresseMail,USER_dateNaissance,USER_motDePasse) VALUES ($nom,$prenom,$fonction,$adr,$dt,$pwd);
SQL;
		try{
			echo $requete;
			$pdo->prepare($requete)->execute();
		}catch(PDOException $e){
        	$message="erreur d'écriture";
    	}
	}

	function verifAdrMailBDD($pdo,$adresse):bool{
		$trouve=false;

		try{
			$adresseQuote=$pdo->quote($adresse);
			echo $adresse."<br>";
            $requete="SELECT USER_adresseMail FROM COMPTE_USER WHERE USER_adresseMail IN (".$adresseQuote.")";
            echo $requete."<br>";
            $resultRequete=$pdo->query($requete);
        }catch (PDOException $e){
            $message="erreur de requête";
        }
        $resultRequete->setFetchMode(PDO::FETCH_ASSOC);
        try{
            //recherche si le login saisi existe déja
            //while(($res = $resultRequete->fetch())){
        	$res = $resultRequete->fetch();
                if($res['USER_adresseMail']===$adresse){
                    $trouve=true;
                    $message="l'adresse ".$res['USER_adresseMail']." existe<br>";
                }else{
                    $trouve=false;
                    $message="OK<br>";
                }
            //} 
        }catch (PDOException $e){
            $message="erreur retour de requête";
        }

        echo $message;
        return (!$trouve);

	}




?>