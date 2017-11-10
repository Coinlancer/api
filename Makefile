ARGS = $(filter-out $@,$(MAKECMDGOALS))
MAKEFLAGS += --silent

list:
	sh -c "echo; $(MAKE) -p no_targets__ | awk -F':' '/^[a-zA-Z0-9][^\$$#\/\\t=]*:([^=]|$$)/ {split(\$$1,A,/ /);for(i in A)print A[i]}' | grep -v '__\$$' | grep -v 'Makefile'| sort"

#############################
# Docker machine states
#############################

start:
	docker-compose start

stop:
	docker-compose stop

state:
	docker-compose ps

build:
	sudo mkdir -p files files/project_attachments files/accounts files/accounts/avatars
	sudo chown www-data:www-data files files/project_attachments files/accounts files/accounts/avatars

	@if [ ! -f ./.env ]; then\
  	read -p "Enter database username: " db_user; echo "DB_USER=$$db_user" >>./.env; \
  	read -p "Enter database password: " db_pass; echo "DB_PASSWORD=$$db_pass" >>./.env; \
  	read -p "Enter database name: " db_name; echo "DB_NAME=$$db_name" >>./.env; \
  	read -p "Enter SmartContract bot host:" bot_host; echo "SCBOT_HOST=$$bot_host" >> ./.env; \
  	read -p "Enter SmartContract bot username:" bot_username; echo "SCBOT_USERNAME=$$bot_username" >> ./.env; \
  	read -p "Enter SmartContract bot password:" bot_password; echo "SCBOT_PASSWORD=$$bot_password" >> ./.env; \
  	read -p "Enter SMTP host:" smtp_host; echo "SMTP_HOST=$$smtp_host" >> ./.env; \
  	read -p "Enter SMTP port:" smtp_port; echo "SMTP_PORT=$$smtp_port" >> ./.env; \
  	read -p "Enter SMTP security:" smtp_security; echo "SMTP_SECURITY=$$smtp_security" >> ./.env; \
  	read -p "Enter SMTP username:" smtp_user; echo "SMTP_USER=$$smtp_user" >> ./.env; \
  	read -p "Enter SMTP password:" smtp_pass; echo "SMTP_PASS=$$smtp_pass" >> ./.env; \
  	read -p "Debug mode [skip empty for disable or type anything]:" debug; echo "DEBUG=$$debug" >> ./.env; \
	fi
	docker-compose build
	docker-compose up -d

make attach:
	docker exec -i -t ${c} /bin/bash

purge:
	docker-compose down