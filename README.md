# Bezily

Platforma e-learningowa pozwalająca tworzyć kursy, zadania, zapraszać użytkowników, rozwiązywać zadania jak i sprawdzać udzielone odpowiedzi.
Program wymaga zainstalowanego dockera do uruchamienia aplikacji.

Aplikacja będzie do momentu otrzymania oceny hostowana za pomocom Azure<br>
Link do strony: http://20.206.250.86:8080/<br>
Link do pgadmin: http://20.206.250.86:5050/

Za pomocą pgadmin można otrzymać wgląd do bazy danych<br>
Aby go otrzymać należy się zalogować<br>
email: admin@admin.pl<br>
hasło: admin<br>

Następnie wybrać bazę danych z listy o nazwie 'baza'

Jeśli poprosi o hasło należy podać: docker

W przypadku uruchomienia aplikacji na localhost:

Komenda do uruchomienia z poziomu katalogu aplikacji:

docker compose up

Utworzy to cztery kontenery odpowiedzialne za:

hosting - nginx<br>
obsługę requestów - php<br>
baza danych - pgsql<br>
dostęp administratora do bazy danych - pgadmin

Po uruchominiu programu za pierwszym razem należy załadować bazę danych przez pgadmin

Ten sam email i hasło co wcześniej<br>
Następnie trzeba wybrać: 'Add new server'<br>
name: dowolne<br>
Następnie w connections:<br>
host name: db<br>
Username: docker<br>
Hasło: docker<br>
Zatwierdzić, następnie w tools > storage manager<br>
Dodać plik database znajdujący się w głównym katalogu<br>
Następnie wybrać bazę danych db i  wybrać tools > restore<br>
Wybrać plik database i potwierdzić restore.

Następnie na poziomie strony wszystko powinno działać

Istnieje przygotowany użytkownik:<br>
Username: docker<br>
Hasło: docker<br>
Z przygotowanymi zadaniami i kursami do których można zapraszać nowych użytkowników.<br>