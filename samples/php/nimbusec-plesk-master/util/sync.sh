#!/bin/bash

function sync () {
	fetched=$(docker ps --no-trunc --quiet --filter "ancestor=plesk/plesk")
	readarray -t instances <<< "$fetched"

	if [[ ${#instances[@]} > 2 ]]; then
		>&2 printf "multiple plesk instances running. abort... \n"
		exit 1
	fi

	current=${instances[0]}

	# libraries
	docker cp ../src/plib/library/ $current:/opt/psa/admin/plib/modules/nimbusec-agent-integration/

	# scripts
	docker cp ../src/plib/scripts/ $current:/opt/psa/admin/plib/modules/nimbusec-agent-integration/

	# resources
	docker cp ../src/plib/resources/locales/ $current:/opt/psa/admin/plib/modules/nimbusec-agent-integration/resources/

	# controller
	docker cp ../src/plib/controllers/ $current:/opt/psa/admin/plib/modules/nimbusec-agent-integration/

	# views
	docker cp ../src/plib/views/scripts/ $current:/opt/psa/admin/plib/modules/nimbusec-agent-integration/views/

	# resources
	docker cp ../src/htdocs/css/ $current:/opt/psa/admin/htdocs/modules/nimbusec-agent-integration/
	docker cp ../src/htdocs/fonts/ $current:/opt/psa/admin/htdocs/modules/nimbusec-agent-integration/
}

export -f sync
watch bash -c sync
