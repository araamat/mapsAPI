# :door:LIVE: https://hajus.ta23raamat.itmajakas.ee/
**Alternatiiv: https://mapsapi-lgxu.onrender.com/**

### **Hajusrakenduse ülesanded**  
### **1. Ilmateenuse API liidestus**  :white_check_mark:TEHTUD
#### :door:LIVE: https://hajus.ta23raamat.itmajakas.ee/dashboard
Alternatiiv: https://mapsapi-lgxu.onrender.com/dashboard
- Valida vabalt sobiv ilma API (nt https://openweathermap.org/api või muu sarnane teenus).
- API-ga ühendumine ja ilmaandmete hankimine (eelistatud formaadis JSON või XML).
- Andmete lokaalne vahemälu (cache), et vähendada API päringute arvu ja optimeerida kiirust.
- Ilmaandmete kuvamine veebilehel, eelistatult koos visuaalsete elementidega (nt ikoonid või pildid vastavalt ilmastikuoludele).
- Lisafunktsionaalsus: võimalus otsida ilmaandmeid eri linnade või riikide kohta.

#### **2. Kaardirakendus API liidestus** :white_check_mark:TEHTUD
#### :door:LIVE: https://hajus.ta23raamat.itmajakas.ee/dashboard
Alternatiiv: https://mapsapi-lgxu.onrender.com/dashboard
- Valida sobiv kaardi API (nt Google Maps, OpenStreetMap, Radar Maps vms).
- Luua andmebaasitabel `markers`, millel on järgmised väljad: `id`, `name`, `latitude`, `longitude`, `description`, `added`, `edited`.
- Rakendada markerite haldusfunktsioonid (lisamine, vaatamine, muutmine, kustutamine).
- Luua kaardivaade, mis kuvab kõik lisatud markerid.
- Võimalus klõpsata kaardil, et salvestada uus marker koos kirjelduse ja koordinaatidega.
- Kasulikud juhendid:
  - [Google Maps API juhend](https://developers.google.com/maps/documentation/javascript/tutorial)
  - [Radar Maps API dokumentatsioon](https://radar.com/documentation/maps/maps)

---

### **Veebirakenduste arendamine** :white_check_mark:TEHTUD
#### **3. Blogi ja Kommentaaride haldus** <span style="color: red;">POOLELI</span>
#### :door:LIVE: https://hajus.ta23raamat.itmajakas.ee/posts
Alternatiiv: https://mapsapi-lgxu.onrender.com/posts
- Luua blogifunktsionaalsus.
- Lisada autentimissüsteem (registreerimine ja sisselogimine).
- Luua andmebaasitabel **blogi postitustele**, mille väljad on `id`, `title`, `description`, `created_at`, `updated_at`.
- Teostada blogi sissekannete CRUD (postituste lisamine, muutmine, kustutamine ja vaatamine).
- Lisada võimalus postitustele kommentaare lisada ning administraatori poolt kommentaare hallata (sh kustutada).

#### **4. E-pood ja ostukorvi funktsionaalsus** :white_check_mark:TEHTUD
#### :door:LIVE: https://hajus.ta23raamat.itmajakas.ee/products
Alternatiiv: https://mapsapi-lgxu.onrender.com/products
- Luua **toote leht**, kus on vähemalt 9 erinevat toodet (pilt, nimi, hind, kirjeldus, koguse valik).
- Rakendada **ostukorvi funktsionaalsus**, kus kasutaja saab:
  - Lisada tooteid ostukorvi.
  - Muuta ostukorvis olevate toodete kogust.
  - Kustutada tooteid ostukorvist.
- Luua **maksmise leht**, kus käsitletakse kasutaja andmeid (eesnimi, perenimi, email, telefon) ja antakse suunamine maksmiseks.
- Pärast maksmise toimingut:
  - Kui makse on edukas, tühjendatakse ostukorv.
  - Kui makse ebaõnnestub, jäävad tooted ostukorvi alles.

#### **5. API loomine valitud lemmikteema kohta** :white_check_mark:TEHTUD
#### :door:LIVE: https://hajus.ta23raamat.itmajakas.ee/movies
https://hajus.tak23mand.itmajakas.ee/api/favourite/07b4cc44-9042-4944-b1dc-56eac757ca4f
- `GET /api/movies`
  - `?search=...`
  - `?sort_by=...&sort_order=asc|desc`
  - `?limit=...`
**Enda filmide all kuvan slackis olnud Kert Mänd api andmeid: https://hajus.tak23mand.itmajakas.ee/api/favourite/07b4cc44-9042-4944-b1dc-56eac757ca4f**
- Valida endale isiklikult huvipakkuv teema (nt raamatud, filmid, toiduretseptid, matkamine vms) ning luua sellele põhinev API.
- Luua andmebaasitabel my_favorite_subject, mille väljad on id, title, image, description, ja vähemalt kaks teemale omast lisaandmevälja (nt raamatute puhul author ja publication_year).
- Luua kasutajasõbralik andmete sisestamise vorm, mis võimaldab kõigi vajalike väljade täitmist (title, description, image, +2 teemaspetsiifilist välja).
- Luua dokumenteeritud JSON API, mis:
    - Väljastab sisestatud andmeid koos filtreerimis- ja sorteerimisfunktsioonidega
    - Võimaldab piirata tagastatavate kirjete arvu (parameetriga limit)
    - Pakub otsingufunktsionaalsust vähemalt ühe välja põhjal
  Teha veebileht, kus on näha nii enda kui ka teiste lisatud sisu ning võimalus neid sirvida ja filtreerida.
- Lisada andmete vahemäluga salvestamine (cache), et optimeerida API päringuid ja parandada rakenduse jõudlust.
