MAKEFLAGS += --warn-undefined-variables
SHELL := /bin/bash
.SHELLFLAGS := -eu -o pipefail -c
.DEFAULT_GOAL := build

NS = quay.io/illuminateeducation
REPO ?= sqlboss
VERSION ?= $(shell basename `git rev-parse HEAD`)
BRANCH ?= $(shell basename `git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/\1/'`)
export REPO := ${REPO}
export VERSION := ${VERSION}
export NAME := ${REPO}
export BRANCH := ${BRANCH}

.PHONY: build
build:
	docker build -t $(NS)/$(REPO):$(VERSION) .

.PHONY: compose
compose:
	docker-compose up --build

.PHONY: shell
shell:
	docker run --rm --name $(NAME) -i -t $(PORTS) $(VOLUMES) $(ENV) $(NS)/$(REPO):$(VERSION) /bin/bash

.PHONY: run
run:
	docker run --rm --name $(NAME) $(PORTS) $(VOLUMES) $(ENV) $(NS)/$(REPO):$(VERSION)

.PHONY: start
start:
	docker run -d --name $(NAME) $(PORTS) $(VOLUMES) $(ENV) $(NS)/$(REPO):$(VERSION)

.PHONY: migration
migration:
	Vendor/cakephp/cakephp/lib/Cake/Console/cake schema create sqlboss \
	Vendor/cakephp/cakephp/lib/Cake/Console/cake schema create sessions

.PHONY: user
user:
	Vendor/cakephp/cakephp/lib/Cake/Console/cake user create admin admin

.PHONY: bash
bash:
	docker-compose exec -it sqlboss /bin/bash

.PHONY: psql
psql:
	docker exec -it sqlboss_db_1 psql -U docker -d sqlboss

.PHONY: stop
stop:
	docker stop $(NAME)

.PHONY: rm
rm:
	docker rm $(NAME)

.PHONY: tag
tag:
	docker tag $(NS)/$(REPO):$(VERSION) $(NS)/$(REPO):$(BRANCH)

.PHONY: push
push:
	docker push $(NS)/$(REPO):$(VERSION)
	docker push $(NS)/$(REPO):$(BRANCH)

.PHONY: release
release: build
	make push -e VERSION=$(VERSION)
