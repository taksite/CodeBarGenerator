# Kody - generator kodów EAN
* program wspomagający wprowadzanie towarów do bazy danych, generuje plik html z kodami, kody można użyć, drukując bądź, 
* gdy ma się model skanera odczytujący kody EAN z ekranu (np.) ZEBRA DS2208. Zdecydowanie ułatwia to wprowadzanie i wyszukiwanie towaru.
* 

## Technologie:
* PHP 8.0.10 - https://www.php.net/
* Barcode https://github.com/kreativekorp/barcode

## Jak przygotować: 
* upewnij się, ze zainstalowałeś w systemie php w wersji 8.0.10
* wyeksportuj ze swojej bazy danych plik i przygotuj go w CSV  rozdzielonym ; (np. w Excel)
* kolejność danych w linii:
* id assort, name, ean, quantity, price_purch,  vat, price_sell
* czyli: id towaru, nazwa towaru, ilość, cena zakupu, stawka VAT, cena sprzedaży, kod EAN
* przykładowy plik: towary.csv
* UWAGA! pomiń nazwy kolumn, Excel przy zapisie do CSV lubi zostawić pustą linię na końcu, należy ją skasować, np w notepad++

## Jak uruchomić:
* php index.php towary.csv
* towary.csv - nazwa pliku do konwersji
* ew. podaj nazwę pliku do zapisu
