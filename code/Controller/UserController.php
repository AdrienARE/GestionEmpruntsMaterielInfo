<?php
require_once(__DIR__ . "/../Controller/Functions.php");

require_once(__DIR__ . "/../ControllerDAO/BorrowDAO.php");
require_once(__DIR__ . "/../ControllerDAO/UserDAO.php");
require_once(__DIR__ . "/../Controller/EquipmentController.php");
require_once(__DIR__ . "/../Controller/BorrowController.php");

/**
 * Manages and performes actions on/by a User object. Uses a userDAO class.
 * Class UserController
 *
 * @author Alhabaj Mahmod, Anica Sean, Belda Tom, Ingarao Adrien, Maggouh Naoufal, Ung Alexandre.
 *
 */
class UserController
{
    /**
     * @var User|null
     */
    private $_user;

    /**
     * @var UserDAO
     */
    private $_userDAO;


    /**
     * UserController constructor.
     *
     * @param int|null $id for userID or nothing to only initialize the UserDAO Class
     */
    public function __construct(int $id = null)
    {
        if ($id == null) {
            $this->_userDAO = new UserDAO();
        } else {
            if (is_numeric($id)) {
                $this->_userDAO = new UserDAO();
                $this->_user = $this->_userDAO->getUserByID($id);
            }
        }
    }

    /**
     * Destroys session and it's variables.
     *
     * @return void
     */
    public function disconnect(): void
    {
        session_unset();
        session_destroy();
    }

    /**
     * Starts a borrow using the ref_equip, endDate, quantity for a given IdUser
     *
     * @param EquipmentController $equipmentController
     * @param                     $ref_equip_toBorrow
     * @param                     $dateFin
     * @param                     $quantity
     * @param                     $idUser
     *
     * @return bool true if borrow created successfully, else false.
     * PREC : quantity > 0 && reservation date after current server date
     * @throws Exception
     */
    public function startBorrow(EquipmentController $equipmentController, $ref_equip_toBorrow, $dateFin, $quantity, $idUser): bool
    {
        if (Functions::checkReservationDate($dateFin) && Functions::checkQuantityEquipment($quantity)) {
            if ($equipmentController->getEquipmentDAO()->howMuchAvailable($ref_equip_toBorrow) >= $quantity && $quantity > 0) {

                $indexOf = 0;
                while ($indexOf < $quantity) {
                    $tmpBorrowController = new BorrowController();
                    $newBorrow = $tmpBorrowController->getBorrowDAO()->startBorrow($ref_equip_toBorrow, $dateFin, $idUser);
                    $newBorrow->setEndDate($dateFin);
                    $this->_user->addBorrowToList($newBorrow);
                    $indexOf += 1;
                }
                return true;

            } else {
                throw new Exception("Reservation Impossible: quantite de materiel disponible insuffisante");

            }

        }
        return false;
    }

    /**
     * Ends a borrow given it's ID for the currentUser
     *
     * @param $id_borrow_toDel
     *
     * @throws Exception
     */
    public function endBorrow($id_borrow_toDel)
    {
        date_default_timezone_set('Europe/Paris');
        $currentDateTime = date('Y/m/d');
        $end_date = $currentDateTime;
        $cpt_array = 0;
        foreach ($this->_user->getBorrowList() as $borrow):
            if ($borrow->getIdBorrow() == $id_borrow_toDel) {
                $tmpBorrowController = new BorrowController();
                $tmpBorrowController->getBorrowDAO()->stopBorrow($borrow->getIdBorrow(), $borrow->getDeviceId(), $end_date);
                unset($this->_user->getBorrowList()[$cpt_array]);
                break;
            }
            $cpt_array += 1;
        endforeach;
    }


    /**
     *
     * Registers a new User into the database.
     *
     * @param $matricule
     * @param $password
     * @param $passwordRepeat
     * @param $email
     * @param $lastname
     * @param $name
     * @param $phone
     * @param $isAdmin
     *
     * @return bool
     * @throws Exception
     */
    public function createUser($matricule, $password, $passwordRepeat, $email, $lastname, $name, $phone, $isAdmin): bool
    {
        if ($passwordRepeat != $password) {
            throw new Exception("Les deux mots de passe ne correspondent pas !");
        }

        $hashedPassword = sha1($password);

        if ($this->_userDAO->matriculeUserExists($matricule) == false
            && Functions::checkMatricule($matricule) == true
            && Functions::checkMail($email) == true
            && Functions::checkPhoneNumber($phone) == true
            && Functions::checkNameUser($lastname) == true
            && Functions::checkFirstNameUser($name) == true) {

            $this->_user = new User();

            $this->_userDAO->createUser($matricule, $email, $hashedPassword, $name, $lastname, $phone, $isAdmin);
            $this->_user->setMatriculeUser($matricule);
            $this->_user->setEmail($email);
            $this->_user->setLastName($lastname);
            $this->_user->setFirstName($name);
            $this->_user->setPhone($phone);
            $this->_user->setIsAdmin($isAdmin);

            return true;
        } else
            return false;


    }


    /**
     * Modifies a user given it's ID
     *
     * @param $id
     * @param $matricule
     * @param $email
     * @param $lastname
     * @param $name
     * @param $phone
     * @param $isAdmin
     *
     * @return bool
     * @throws Exception
     */
    public function modifyUser($id, $matricule, $email, $lastname, $name, $phone, $isAdmin): bool
    {

        if (Functions::checkMatricule($matricule) == true
            && Functions::checkMail($email) == true
            && Functions::checkPhoneNumber($phone) == true
            && Functions::checkNameUser($lastname) == true
            && Functions::checkFirstNameUser($name) == true) {

            $this->_userDAO->modifyUser($id, $matricule, $email, $name, $lastname, $phone, $isAdmin);
            $this->_user->setMatriculeUser($matricule);
            $this->_user->setEmail($email);
            $this->_user->setLastName($lastname);
            $this->_user->setFirstName($name);
            $this->_user->setPhone($phone);
            $this->_user->setIsAdmin($isAdmin);
            return true;
        } else
            return false;

    }

    /**
     * Modifies current user password's
     *
     * @param $password
     * @param $passwordRepeat
     *
     * @return bool
     * @throws Exception
     */
    public function modifyPassword($password, $passwordRepeat): bool
    {
        if ($password == '' || $password == null) {
            return false;
        }
        if ($password == $passwordRepeat) {
            $hashedNewPassword = sha1($password);
            $this->_userDAO->changeUserPassword($this->_user, $password);
            $this->_user->setPassword($hashedNewPassword);
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return mixed
     */
    public function getUser(): ?User
    {
        return $this->_user;
    }

    /**
     * @return UserDAO
     */
    public function getUserDAO(): UserDAO
    {
        return $this->_userDAO;
    }


    /**
     * @param UserDAO $userDAO
     */
    public function setUserDAO(UserDAO $userDAO): void
    {
        $this->_userDAO = $userDAO;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->_user = $user;

    }
}