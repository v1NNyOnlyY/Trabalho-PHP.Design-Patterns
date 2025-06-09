Exemplo prático (com Python e SQLAlchemy):
Sem ORM (usando SQL diretamente):
cursor.execute("SELECT * FROM usuarios WHERE id = 1")
linha = cursor.fetchone()
print(linha["nome"])


Com ORM (SQLAlchemy):
usuario = session.query(Usuario).get(1)
print(usuario.nome)


Vantagens de usar ORM:
Menos código SQL: Você escreve menos SQL diretamente.

Mais legibilidade: O código fica mais limpo e fácil de manter.

Abstração do banco de dados: Seu código pode ser mais facilmente adaptado a outro banco.

Integração com a lógica do programa: Objetos da linguagem são usados diretamente.

Desvantagens:
Menor controle sobre o SQL gerado (pode não ser tão otimizado).

Curva de aprendizado para entender o mapeamento.

Não resolve todos os problemas — consultas complexas ainda podem precisar de SQL puro.

Exemplos de ORMs populares:
Python: SQLAlchemy, Django ORM, Peewee

Java: Hibernate

C#: Entity Framework

Ruby: ActiveRecord (usado no Rails)

