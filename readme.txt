Bezily

Platforma e-learningowa pozwalająca tworzyć kursy, zadania, zapraszać użytkowników, rozwiązywać zadania jak i sprawdzać udzielone odpowiedzi.
Program wymaga zainstalowanego dockera do uruchamienia aplikacji.

Aplikacja będzie do momentu otrzymania oceny hostowana za pomocom Azure
Link do strony: http://20.206.250.86:8080/
Link do pgadmin: http://20.206.250.86:5050/

Za pomocą pgadmin można otrzymać wgląd do bazy danych
Aby go otrzymać należy się zalogować
email: admin@admin.pl
hasło: admin

Następnie wybrać bazę danych z listy o nazwie 'baza'

Jeśli poprosi o hasło należy podać: docker

W przypadku uruchomienia aplikacji na localhost:

Komenda do uruchomienia z poziomu katalogu aplikacji:

docker compose up

Utworzy to cztery kontenery odpowiedzialne za:

hosting - nginx
obsługę requestów - php
baza danych - pgsql
dostęp administratora do bazy danych - pgadmin

Po uruchominiu programu za pierwszym razem należy załadować bazę danych przez pgadmin

Ten sam email i hasło co wcześniej
Następnie trzeba wybrać: 'Add new server'
name: dowolne
Następnie w connections:
host name: db
Username: docker
Hasło: docker
Zatwierdzić, następnie w tools > storage manager
Dodać plik database znajdujący się w głównym katalogu
Następnie wybrać bazę danych db i  wybrać tools > restore
Wybrać plik database i potwierdzić restore.

Następnie na poziomie strony wszystko powinno działać

Istnieje przygotowany użytkownik:
Username: docker
Hasło: docker
Z przygotowanymi zadaniami i kursami do których można zapraszać nowych użytkowników.