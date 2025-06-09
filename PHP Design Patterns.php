
Aplicando Design Patterns em Projetos PHP
Design Patterns são soluções reutilizáveis para problemas comuns no desenvolvimento de software. Vamos explorar como aplicar alguns dos padrões mais úteis em projetos PHP.

Padrões Fundamentais para PHP
1. Singleton (Padrão Criacional)
Quando usar: Quando você precisa garantir que uma classe tenha apenas uma instância durante todo o ciclo de vida da aplicação.

Exemplo em PHP 

<?php
class DatabaseConnection {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new PDO(
            "mysql:host=localhost;dbname=test", 
            "user", 
            "password"
        );
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}

// Uso:
$db = DatabaseConnection::getInstance();
$conn = $db->getConnection();






Factory Method (Padrão Criacional)
Quando usar: Quando você precisa criar objetos, mas quer que as subclasses decidam qual classe instanciar.

Exemplo em PHP:


<?php
interface Logger {
    public function log(string $message);
}

class FileLogger implements Logger {
    public function log(string $message) {
        file_put_contents('app.log', $message, FILE_APPEND);
    }
}

class DatabaseLogger implements Logger {
    public function log(string $message) {
        // Implementação para log no banco de dados
    }
}

abstract class LoggerFactory {
    abstract public function createLogger(): Logger;

    public function logMessage(string $message) {
        $logger = $this->createLogger();
        $logger->log($message);
    }
}

class FileLoggerFactory extends LoggerFactory {
    public function createLogger(): Logger {
        return new FileLogger();
    }
}

// Uso:
$factory = new FileLoggerFactory();
$factory->logMessage("Erro ocorrido");



 Strategy (Padrão Comportamental)
Quando usar: Quando você quer definir uma família de algoritmos, encapsular cada um e torná-los intercambiáveis.

Exemplo em PHP:


<?php
interface PaymentStrategy {
    public function pay(float $amount): void;
}

class CreditCardPayment implements PaymentStrategy {
    public function pay(float $amount): void {
        echo "Paying $amount via Credit Card";
    }
}

class PayPalPayment implements PaymentStrategy {
    public function pay(float $amount): void {
        echo "Paying $amount via PayPal";
    }
}

class ShoppingCart {
    private $paymentStrategy;

    public function setPaymentStrategy(PaymentStrategy $strategy) {
        $this->paymentStrategy = $strategy;
    }

    public function checkout(float $amount) {
        $this->paymentStrategy->pay($amount);
    }
}

// Uso:
$cart = new ShoppingCart();
$cart->setPaymentStrategy(new CreditCardPayment());
$cart->checkout(100.50);





Observer (Padrão Comportamental)
Quando usar: Quando você precisa notificar múltiplos objetos sobre mudanças em outro objeto.

Exemplo em PHP:

<?php
interface Observer {
    public function update(string $event);
}

class UserObserver implements Observer {
    public function update(string $event) {
        echo "UserObserver: Received event '$event'\n";
    }
}

class LogObserver implements Observer {
    public function update(string $event) {
        file_put_contents('events.log', $event, FILE_APPEND);
    }
}

class User {
    private $observers = [];

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function changeEmail(string $email) {
        // Lógica para mudar email
        
        foreach ($this->observers as $observer) {
            $observer->update("Email changed to $email");
        }
    }
}

// Uso:
$user = new User();
$user->attach(new UserObserver());
$user->attach(new LogObserver());
$user->changeEmail('new@email.com');



Repository (Padrão Arquitetural)
Quando usar: Para abstrair a camada de acesso a dados, tornando o código mais limpo e testável.

Exemplo em PHP:

<?php
interface UserRepository {
    public function find(int $id): ?User;
    public function save(User $user): void;
    public function delete(User $user): void;
}

class DatabaseUserRepository implements UserRepository {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function find(int $id): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        return $data ? new User($data['id'], $data['name']) : null;
    }

    // Implementar outros métodos...
}

// Uso:
$pdo = new PDO('mysql:host=localhost;dbname=test', 'user', 'pass');
$userRepository = new DatabaseUserRepository($pdo);
$user = $userRepository->find(1);





Boas Práticas na Aplicação de Design Patterns em PHP
Não force padrões onde não são necessários - 


Use padrões apenas quando resolverem um problema real.

Prefira composição sobre herança - Muitos padrões enfatizam isso (como Strategy, Observer).

Use interfaces - A maioria dos padrões funciona melhor com interfaces bem definidas.

Mantenha o código testável - Os padrões devem facilitar os testes, não dificultar.

Documente o uso de padrões - Comente no código quando estiver aplicando um padrão específico.

Adapte os padrões ao PHP - Alguns padrões do GoF podem precisar de adaptações para se encaixarem melhor no ecossistema PHP.

Frameworks PHP e Design Patterns
Muitos frameworks PHP já implementam padrões de projeto:

Laravel: Usa Factory, Repository, Observer, Strategy

Symfony: Dependency Injection (uma variação do padrão Strategy)

Zend/Laminas: MVC (uma combinação de vários padrões)

Ao trabalhar com frameworks, é importante entender como eles implementam esses padrões para aproveitar ao máximo seus recursos.

Design Patterns podem elevar significativamente a qualidade do seu código PHP quando aplicados corretamente, tornando-o mais flexível, manutenível e escalável.