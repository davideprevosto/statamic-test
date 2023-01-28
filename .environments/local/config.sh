START_FOLDER=$(pwd)

AUTO_UPDATE_LOCAL_SCRIPTS_VERSION=1

#########################################################
# Applicazione
#########################################################

# Specifica quale ambiente applicativo è usato per il progetto.
# Questa variabile può essere sovrascritta runtime, se passata come argomento
# allo script di avvio (vedere encodia-start e update.sh).
#
# Al momento sono supportati questi valori:
#
# valet    (il default)
# sail
# lando
#
DEV_ENVIRONMENT="valet"

# Default: 0
# Se valorizzato a 1, indica che il progetto è un package Laravel.
# Non vengono usati né database né virtualhost Nginx.
#
IS_PACKAGE_ONLY=0

# Default: 1
#
# Se valorizzato a 0, indica che il progetto non utilizza npm.
# In questo caso:
# - non cambia versione di Node
# - non installa le dipendenze di package.json
# - non esegue lo script di default (Es. npm run dev)
#
USE_NPM=1


# Versione di PHP (8.0, 8.1, 8.2)
APP_PHP_VERSION="8.1"
# Versione di NodeJS
APP_NODE_VERSION="16"
# Gestore di dipendenze Node (npm, yarn)
APP_NODE_MANAGER="npm"

# Dominio utilizzato in locale (senza protocollo)
APP_LOCAL_DOMAIN="mqr.test"

# Specifica se è abilitato o meno il controllo della salute dell'applicazione
# Impostare a zero per non eseguire alcun comando (es. se nessun package dedicato a
# a questa operazione è installato
APP_HEALTH_CHECK_ENABLED=1

# Se APP_HEALTH_CHECK_ENABLED=1, verrà eseguito il comando sottostante.
# Nel progetto Laravel, installare il package necessario e configurarlo opportunamente.
APP_HEALTH_ARTISAN_COMMAND="php artisan health:check --fail-command-on-failing-check"

# Comando npm <comando> da eseguire dopo l'installazione delle dipendenze Node.js.
# Lasciare vuoto per non eseguire nessun comando
NPM_RUN_SCRIPT="dev"
