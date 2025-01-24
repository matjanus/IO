<?

class Package {
    private $name;
    private $id;
    private $isHidden;
    private $isComplited;
    private $id_course;

    public function __construct(int $id, string $name, bool $isHidden, int $id_course){ 
        $this->id = $id;
        $this->name = $name;
        $this->isHidden = $isHidden;
        $this->isComplited = false;
        $this->id_course = $id_course;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getIsHidden() : bool {
        return $this->isHidden;
    }

    public function setIsComplited(bool $isComplited) : void {
        $this->isComplited = $isComplited;
    }

    public  function getCourseId() : int {
        return $this->id_course;
    }

}