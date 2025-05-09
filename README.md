# :door:LIVE: https://hajus.ta23raamat.itmajakas.ee/ (või https://mapsapi-lgxu.onrender.com/)

### **Hajusrakenduse ülesanded**  
#### **1. Ilmateenuse API liidestus**  :white_check_mark:TEHTUD
##### :door:LIVE: https://hajus.ta23raamat.itmajakas.ee/dashboard (või https://mapsapi-lgxu.onrender.com/dashboard)
- Valida vabalt sobiv ilma API (nt https://openweathermap.org/api või muu sarnane teenus).
- API-ga ühendumine ja ilmaandmete hankimine (eelistatud formaadis JSON või XML).
- Andmete lokaalne vahemälu (cache), et vähendada API päringute arvu ja optimeerida kiirust.
- Ilmaandmete kuvamine veebilehel, eelistatult koos visuaalsete elementidega (nt ikoonid või pildid vastavalt ilmastikuoludele).
- Lisafunktsionaalsus: võimalus otsida ilmaandmeid eri linnade või riikide kohta.

#### **2. Kaardirakendus API liidestus** :white_check_mark:TEHTUD
##### :door:LIVE: https://hajus.ta23raamat.itmajakas.ee/dashboard (või https://mapsapi-lgxu.onrender.com/dashboard)
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
##### :door:LIVE: https://hajus.ta23raamat.itmajakas.ee/posts või (https://mapsapi-lgxu.onrender.com/posts)
- Luua blogifunktsionaalsus.
- Lisada autentimissüsteem (registreerimine ja sisselogimine).
- Luua andmebaasitabel **blogi postitustele**, mille väljad on `id`, `title`, `description`, `created_at`, `updated_at`.
- Teostada blogi sissekannete CRUD (postituste lisamine, muutmine, kustutamine ja vaatamine).
- Lisada võimalus postitustele kommentaare lisada ning administraatori poolt kommentaare hallata (sh kustutada).

#### **4. E-pood ja ostukorvi funktsionaalsus** :white_check_mark:TEHTUD
##### :door:LIVE: https://hajus.ta23raamat.itmajakas.ee/products (või https://mapsapi-lgxu.onrender.com/products)
- Luua **toote leht**, kus on vähemalt 9 erinevat toodet (pilt, nimi, hind, kirjeldus, koguse valik).
- Rakendada **ostukorvi funktsionaalsus**, kus kasutaja saab:
  - Lisada tooteid ostukorvi.
  - Muuta ostukorvis olevate toodete kogust.
  - Kustutada tooteid ostukorvist.
- Luua **maksmise leht**, kus käsitletakse kasutaja andmeid (eesnimi, perenimi, email, telefon) ja antakse suunamine maksmiseks.
- Pärast maksmise toimingut:
  - Kui makse on edukas, tühjendatakse ostukorv.
  - Kui makse ebaõnnestub, jäävad tooted ostukorvi alles.

#### **5. API loomine valitud lemmikteema kohta** :x:POLE ALUSTATUD
- Valida endale huvipakkuv teema ning luua sellele põhinev API.
- Luua andmebaasitabel `my_favorite_subject`, mille väljad on `id`, `title`, `image`, `description`, ja vähemalt kaks teemale omast lisaandmevälja.
- Luua **andmete sisestamise vorm** (title, description, image, +2 teema kohast välja).
- Luua JSON API, mis väljastab sisestatud andmeid koos vähemalt ühe parameetriga (nt `limit`, et piirata andmete hulka).
- Rakendada **veebileht**, mis kuvab teiste kasutajate lisatud teemasid.
- Lisada **andmete vahemäluga salvestamine (cache)**, et optimeerida API päringuid.
