<?php

/**
 * Provides some important methodes for the general data integrity of the program.
 *
 * Class Functions
 *
 * @author Alhabaj Mahmod, Anica Sean, Belda Tom, Ingarao Adrien, Maggouh Naoufal, Ung Alexandre.
 */
class Functions
{
    /**
     *
     * Checks if given Equipment Reference is valid to use.
     * Syntax: '/^(AN|AP|XX)[0-9]{3}$/'
     *
     * @param $inputRefEquip
     *
     * @return bool
     * @throws Exception "La reference que vous avez entré est invalide"
     */
    public static function checkRefEquip($inputRefEquip): bool
    {
        if (preg_match('/^(AN|AP|XX)[0-9]{3}$/', $inputRefEquip)) {
            return true;
        } else {
            throw new Exception("La reference que vous avez entré est invalide");
        }
    }

    /**
     * Checks if given Mail is valid to use.
     * Syntax: '/^([-0-9a-zA-Z.+_])+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}$/'
     *
     * @param $mail
     *
     * @return bool
     * @throws Exception "Le mail que vous avez entré est invalide"
     */
    public static function checkMail($mail): bool
    {
        if (preg_match('/^([-0-9a-zA-Z.+_])+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}$/', $mail)) {
            return true;
        } else {
            throw new Exception("Le mail que vous avez entré est invalide");
        }
    }

    /**
     * Checks if a given phone number is valid.
     * Sytax: '/^(0|(\+33)|(0033))[1-9][0-9]{8}$/'
     *
     * @param $phoneNumber
     *
     * @return bool
     * @throws Exception "Le numéro de telephone que vous avez entré est invalide"
     */
    public static function checkPhoneNumber($phoneNumber): bool
    {

        if ($phoneNumber == null || $phoneNumber == "") {
            return true;
        }
        if (preg_match('/^(0|(\+33)|(0033))[1-9][0-9]{8}$/', $phoneNumber)) {
            return true;
        } else {
            throw new Exception("Le numéro de telephone que vous avez entré est invalide");
        }
    }

    /**
     * Checks if a User Matricule is valid.
     * Syntax: '/^([A-Z]|[a-z]|[0-9]){7}$/'
     *
     * @param $matricule
     *
     * @return bool
     * @throws Exception "Votre identifiant de connexion est invalide, il doit comporter 7 caracteres"
     */
    public static function checkMatricule($matricule): bool
    {
        if (preg_match('/^([A-Z]|[a-z]|[0-9]){7}$/', $matricule)) {
            return true;
        } else {
            throw new Exception("Votre identifiant de connexion est invalide, il doit comporter 7 caracteres");
        }
    }

    /**
     * Checks if Equipment Name is Valid.
     * Syntax: '/^[A-Za-z0-9-._,:#() "]{1,30}$/'
     *
     * @param $nom
     *
     * @return bool
     * @throws Exception "Le nom du matériel que vous avez entré est invalide"
     */
    public static function checkNameMateriel($nom): bool
    {
        if (preg_match('/^[A-Za-z0-9-._,:#() "]{1,30}$/', trim($nom))) {
            return true;
        } else {
            throw new Exception("Le nom du matériel que vous avez entré est invalide");
        }
    }

    /**
     * Checks if given version of Equipment is Valid.
     * Syntax: '/^[A-Za-z0-9-._,;:#()"]{3,15}$/'
     *
     * @param $version
     *
     * @return bool
     * @throws Exception "La version du matériel que vous avez entré est invalide"
     */
    public static function checkVersionMateriel($version): bool
    {
        if (preg_match('/^[A-Za-z0-9-._,;:#()"]{3,15}$/', $version)) {
            return true;
        } else {
            throw new Exception("La version du matériel que vous avez entré est invalide");
        }
    }

    /**
     * Checks if User's LastName is valid.
     * Syntax: '/^([A-Z]|[a-z]){1,30}$/'
     *
     * @param $nom
     *
     * @return bool
     * @throws Exception "Le Nom que vous avez entré est invalide"
     */
    public static function checkNameUser($nom): bool
    {
        if (preg_match('/^([A-Z]|[a-z]){1,30}$/', $nom)) {
            return true;
        } else {
            throw new Exception("Le Nom que vous avez entré est invalide");
        }
    }

    /**
     * Checks if user's firstname is valid.
     * Syntax: '/^([A-Z]|[a-z]){1,30}$/'
     *
     * @param $nom
     *
     * @return bool
     * @throws Exception "Le prénom que vous avez entré est invalide"
     */
    public static function checkFirstNameUser($nom): bool
    {
        if (preg_match('/^([A-Z]|[a-z]){1,30}$/', $nom)) {
            return true;
        } else {
            throw new Exception("Le prénom que vous avez entré est invalide");
        }
    }

    /**
     * Checks if Equipment brand name is Valid.
     * Syntax: '/^([A-Za-z0-9-._,;:#() "]){1,30}$/'
     *
     * @param $brand
     *
     * @return bool
     * @throws Exception "Le nom de la marque que vous avez entré est invalide"
     */
    public static function checkBrandEquip($brand): bool
    {
        if (preg_match('/^([A-Za-z0-9-._,;:#() "]){1,30}$/', trim($brand))) {
            return true;
        } else {
            throw new Exception("Le nom de la marque que vous avez entré est invalide");
        }
    }

    /**
     * Checks if Equipment's Type is valid.
     * Syntax: '/^([A-Za-z0-9-._,;:#() "]){1,30}$/'
     *
     * @param $type
     *
     * @return bool
     * @throws Exception "Le type de la marque que vous avez entré est invalide"
     */
    public static function checkTypeEquip($type): bool
    {
        if (preg_match('/^([A-Za-z0-9-._,;:#() "]){1,30}$/', trim($type))) {
            return true;
        } else {
            throw new Exception("Le type de la marque que vous avez entré est invalide");
        }
    }

    /**
     * Checks if Reservation's date is Valid
     * Syntax:
     *
     * @param $entered_date
     *
     * @return bool
     * @throws Exception "La date de fin de réservation est incorrecte (Elle doit être ultérieure à la date
     *                   d'aujourd'hui.). [format : YYYY/MM/DD]"
     */
    public static function checkReservationDate($entered_date): bool
    {
        if ($entered_date != null && strtotime($entered_date) > strtotime('now')) {
            return true;
        } else {
            throw new Exception("La date de fin de réservation est incorrecte (Elle doit être ultérieure à la date d'aujourd'hui.). [format : YYYY/MM/DD]");
        }
    }

    /**
     * Checks if given Quantity number is valid.
     * Syntax: quantity != null and quantity >=0
     *
     * @param $quantite_equip
     *
     * @return bool
     * @throws Exception "Erreur, veuillez choisir une quantité de matériel supérieure à 0"
     */
    public static function checkQuantityEquipment($quantite_equip): bool
    {
        if ($quantite_equip != null && $quantite_equip >= 0) {
            return true;
        } else {
            throw new Exception("Erreur, veuillez choisir une quantité de matériel supérieure à 0");
        }
    }

    /**
     * Uploads Equipment's image to "assets/images/$Type" (given the Equipment Type).
     * Side Note: If Image name is already taken, renames the image: imageName(x) where x is a number.
     *
     *
     * @param $Type Equipment Type
     *
     * @return string|null if imageName already existe, we get imageName(1). If imageName(1) exists, we get
     *                     imageName(2)..Etc. Null if faild.
     * @throws Exception various error messages.
     */
    public static function uploadImage($Type): ?string
    {

        $erreur = '';

        if (!file_exists("assets/images/$Type/")) {
            mkdir("assets/images/$Type/", 0700);
        }


        $sousdossier = 'assets/images/' . $Type . '/';

        $ph = basename($_FILES['photo']['name']);


        $photo = $sousdossier . $Type . $ph;

        // UPLOAD the image
        $fichier = basename($_FILES['photo']['name']);


        if (!empty($fichier)) {


            $taille_maxi = 8388608;
            $taille = filesize($_FILES['photo']['tmp_name']);
            $extensions = array('.PNG', '.png', '.jpg', '.JPG', '.jpeg', '.JPEG', 'gif', 'GIF');
            $extension = strrchr($_FILES['photo']['name'], '.');
            //checks of security
            if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                $erreur = "Seulement les photos de type png, jpg, jpeg et gif sont acceptes";

            }

            if ($taille > $taille_maxi) {
                $erreur = "Photo trop grande ";
            }

            if (empty($erreur)) //if there's no error we upload
            {
                //we parse the file
                $table = array(
                    'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
                    'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
                    'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
                    'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
                    'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
                    'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
                    'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý ' => 'y', 'ý' => 'y', 'þ' => 'b',
                    'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r',
                );
                $fichier = strtr($fichier, $table);
                $fichier = preg_replace('/([^.a-zA-Z0-9]+)/i', '-', $fichier);


                $fichierSplit = explode(".", $fichier);
                $fichierOrig = $fichierSplit[0];
                $fichierOrigbackupName = $fichierSplit[0];
                $num = 0;
                $filenameFULL = $fichier;
                while (file_exists($sousdossier . $fichierOrig . "." . $fichierSplit[1])) {
                    $fichierOrig = (string)$fichierOrigbackupName . "(" . $num . ")";
                    $filenameFULL = $fichierOrig . "." . $fichierSplit[1];
                    $num++;
                }

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $sousdossier . $filenameFULL)) {
                    return $sousdossier . $filenameFULL;
                } else {
                    throw new Exception("Erreur Interne Upload Image");
                }
            } else {
                throw new Exception($erreur);

            }


        }
        return null;
    }

}
