MQR - Applicazione Statamic
===

# Requisiti

## Sviluppo

* PHP 8.1
* Composer
* Valet
* MySql / MariaDB

## Produzione / staging

* PHP 8.1
* MySql / MariaDB

# Tecnologie

# Installazione

```shell
dev # alias: cd <progetti>
cd <cliente/vendor>
git clone git@github.com:davideprevosto/statamic-test.git mqr
cd mqr

git checkout develop # nota: dopo il rilascio, verrà eliminato il ramo

encodia start
```

# Documentazione

## Analisi

## Nomenclatura

| Italiano | Inglese | Descrizione |
|----------|---------|-------------|
| Utente   | User    |             |

## Ambienti

| Ambiente   | URL                                     | Server   | Ramo GIT |
|------------|-----------------------------------------|----------|----------|
| Sviluppo   | https://mqr.test                  | (locale) | develop  |
| Staging    | https://@TODO                           | @todo    | staging  |
| Produzione | https://@TODO                           | @todo    | main     |

## Comandi Artisan

# Deploy

Eseguire

```bash
dep deploy [production|staging|...]
```


