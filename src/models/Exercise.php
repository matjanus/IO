<?

class Exercise {
    private $name;
    private $id;
    private $id_owner;
    private $fields;


    public function __construct(int $id, string $name, int $id_owner){ 
        $this->id = $id;
        $this->name = $name;
        $this->id_owner = $id_owner;
        $this->fields = [];
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function addField(string $fieldName, string $value){
        $this->fields[$fieldName] = $value;
    }

    public function getFields(): array {
        return $this->fields;
    }


}