<?

class Course {
    private $name;
    private $id;
    private $access;

    public function __construct(int $id, string $name){ 
        $this->id = $id;
        $this->name = $name;
        $this->access = null;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function toJson(){
        return ["id" => $this->id,"name" => $this->name];
    }

    public function setAccess($role){
        $this->access = $role;
    }

    public function getAccess(){
        return $this->access;
    }


}