# Tablica zarządzania zadaniami - Symfony + Docker

Prosty system zarządzania zadaniami (Trello-like) zbudowany w oparciu o **Symfony 6.4** i **Docker**.  
Pozwala tworzyć, edytować, grupować oraz przeciągać zadania między kolumnami (statusami).

---

## Funkcje

-  Tworzenie, edytowanie zadań
-  Przeciąganie zadań pomiędzy statusami: `Oczekujący`, `Wykonany`, `Odrzucony`
-  Obsługa podzadań (relacja rodzic → dzieci)
-  Dostęp tylko dla użytkownika z rolą `ROLE_ADMIN`
-  Gotowe środowisko w Dockerze

---

##  Uruchomienie projektu (Docker)

Wystarczy jedno polecenie:

```bash
docker compose up --build
