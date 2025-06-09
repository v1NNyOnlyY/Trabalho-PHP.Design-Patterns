Exemplos de Design Patterns com uma Calculadora PHP

1. Strategy Pattern (Padrão Estratégia)
Útil quando você tem múltiplos algoritmos para operações e quer poder trocá-los facilmente.

<?php
interface OperacaoStrategy {
    public function executar($a, $b);
}

class SomaStrategy implements OperacaoStrategy {
    public function executar($a, $b) {
        return $a + $b;
    }
}

class SubtracaoStrategy implements OperacaoStrategy {
    public function executar($a, $b) {
        return $a - $b;
    }
}

class Calculadora {
    private $strategy;
    
    public function __construct(OperacaoStrategy $strategy) {
        $this->strategy = $strategy;
    }
    
    public function calcular($a, $b) {
        return $this->strategy->executar($a, $b);
    }
}

// Uso:
$calculadora = new Calculadora(new SomaStrategy());
echo $calculadora->calcular(5, 3); // 8

$calculadora = new Calculadora(new SubtracaoStrategy());
echo $calculadora->calcular(5, 3); // 2
?>

2. Factory Method (Método Fábrica)
Útil para criar objetos de operações sem especificar a classe concreta.

<?php
interface Operacao {
    public function calcular($a, $b);
}

class Soma implements Operacao {
    public function calcular($a, $b) {
        return $a + $b;
    }
}

class Subtracao implements Operacao {
    public function calcular($a, $b) {
        return $a - $b;
    }
}

class OperacaoFactory {
    public static function criar($tipo) {
        switch ($tipo) {
            case 'soma':
                return new Soma();
            case 'subtracao':
                return new Subtracao();
            default:
                throw new Exception("Tipo de operação inválido");
        }
    }
}

// Uso:
$operacao = OperacaoFactory::criar('soma');
echo $operacao->calcular(5, 3); // 8

$operacao = OperacaoFactory::criar('subtracao');
echo $operacao->calcular(5, 3); // 2
?>

3. Command Pattern (Padrão Comando)
Útil quando você quer encapsular uma operação como um objeto.

<?php
interface Comando {
    public function executar();
}

class ComandoCalculadora implements Comando {
    private $receptor;
    private $a;
    private $b;
    private $operacao;
    
    public function __construct($receptor, $a, $b, $operacao) {
        $this->receptor = $receptor;
        $this->a = $a;
        $this->b = $b;
        $this->operacao = $operacao;
    }
    
    public function executar() {
        return $this->receptor->{$this->operacao}($this->a, $this->b);
    }
}

class CalculadoraReceptor {
    public function soma($a, $b) {
        return $a + $b;
    }
    
    public function subtracao($a, $b) {
        return $a - $b;
    }
}

// Uso:
$receptor = new CalculadoraReceptor();
$comando = new ComandoCalculadora($receptor, 5, 3, 'soma');
echo $comando->executar(); // 8

$comando = new ComandoCalculadora($receptor, 5, 3, 'subtracao');
echo $comando->executar(); // 2
?>

4. Singleton Pattern (Padrão Singleton)
Útil quando você quer garantir que só exista uma instância da calculadora.

<?php
class CalculadoraSingleton {
    private static $instancia;
    
    private function __construct() {}
    
    public static function getInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }
    
    public function soma($a, $b) {
        return $a + $b;
    }
    
    public function subtracao($a, $b) {
        return $a - $b;
    }
}

// Uso:
$calculadora = CalculadoraSingleton::getInstancia();
echo $calculadora->soma(5, 3); // 8

// Tentar criar nova instância retornará a mesma
$outraCalculadora = CalculadoraSingleton::getInstancia();
echo $outraCalculadora->subtracao(5, 3); // 2
?>




FRAMEWORKS EXEMPLOS:

PHP com Laravel:

// routes/web.php
Route::get('/users', [UserController::class, 'index']);


// app/Http/Controllers/UserController.php
class UserController extends Controller {
    public function index() {
        return User::all(); // Retorna JSON
    }
}


// app/Models/User.php
class User extends Model {
    protected $fillable = ['name', 'email'];
}


Django (Python):

# urls.py
from django.urls import path
from .views import user_list

urlpatterns = [
    path('users/', user_list),
]

# views.py
from django.http import JsonResponse
from .models import User

def user_list(request):
    users = list(User.objects.values())
    return JsonResponse(users, safe=False)


# models.py
from django.db import models

class User(models.Model):
    name = models.CharField(max_length=100)
    email = models.EmailField()


ASP.NET Core (C#):

// Startup.cs or Program.cs (for routing)
app.MapControllerRoute(
    name: "default",
    pattern: "{controller=User}/{action=Index}/{id?}");

// Controllers/UserController.cs
public class UserController : Controller {
    public IActionResult Index() {
        var users = _context.Users.ToList();
        return Json(users);
    }
}

// Models/User.cs
public class User {
    public int Id { get; set; }
    public string Name { get; set; }
    public string Email { get; set; }
}


FastAPI (Python):

# main.py
from fastapi import FastAPI
from pydantic import BaseModel

app = FastAPI()

class User(BaseModel):
    name: str
    email: str

fake_db = []

@app.get("/users")
def get_users():
    return fake_db


Next.js (React + Node.js):

// pages/api/users.js
export default function handler(req, res) {
  const users = [{ name: 'Ana', email: 'ana@email.com' }];
  res.status(200).json(users);
}

// pages/index.js
import useSWR from 'swr';

export default function Home() {
  const { data } = useSWR('/api/users', fetcher);

  return (
    <ul>
      {data?.map(u => <li key={u.email}>{u.name}</li>)}
    </ul>
  );
}



Jinja2 (Python - usado com Flask):
# Python (Flask)
from flask import Flask, render_template

app = Flask(__name__)

@app.route('/')
def home():
    users = [
        {'name': 'Alice', 'email': 'alice@example.com'},
        {'name': 'Bob', 'email': 'bob@example.com'}
    ]
    return render_template('users.html', users=users)


<!-- templates/users.html -->
<ul>
  {% for user in users %}
    <li>{{ user.name }} - {{ user.email }}</li>
  {% endfor %}
</ul>


Django Template Engine:

# views.py
from django.shortcuts import render

def home(request):
    users = [
        {'name': 'Alice', 'email': 'alice@example.com'},
        {'name': 'Bob', 'email': 'bob@example.com'}
    ]
    return render(request, 'users.html', {'users': users})

<!-- templates/users.html -->
<ul>
  {% for user in users %}
    <li>{{ user.name }} - {{ user.email }}</li>
  {% endfor %}
</ul>


Vue.js (Template + JavaScript):

<!-- index.html -->
<div id="app">
  <ul>
    <li v-for="user in users" :key="user.email">
      {{ user.name }} - {{ user.email }}
    </li>
  </ul>
</div>

<script>
  new Vue({
    el: '#app',
    data: {
      users: [
        { name: 'Alice', email: 'alice@example.com' },
        { name: 'Bob', email: 'bob@example.com' }
      ]
    }
  });
</script>



React.js (JSX - JavaScript com HTML):

// App.js
import React from 'react';

const App = () => {
  const users = [
    { name: 'Alice', email: 'alice@example.com' },
    { name: 'Bob', email: 'bob@example.com' }
  ];

  return (
    <ul>
      {users.map(user => (
        <li key={user.email}>
          {user.name} - {user.email}
        </li>
      ))}
    </ul>
  );
};

export default App;


Angular (HTML + TypeScript):

<!-- app.component.html -->
<ul>
  <li *ngFor="let user of users">
    {{ user.name }} - {{ user.email }}
  </li>
</ul>


// app.component.ts
import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html'
})
export class AppComponent {
  users = [
    { name: 'Alice', email: 'alice@example.com' },
    { name: 'Bob', email: 'bob@example.com' }
  ];
}


Laravel Blade (PHP):

// routes/web.php
Route::get('/', function () {
    $users = [
        ['name' => 'Alice', 'email' => 'alice@example.com'],
        ['name' => 'Bob', 'email' => 'bob@example.com']
    ];
    return view('users', compact('users'));
});


<!-- resources/views/users.blade.php -->
<ul>
  @foreach ($users as $user)
    <li>{{ $user['name'] }} - {{ $user['email'] }}</li>
  @endforeach
</ul>
