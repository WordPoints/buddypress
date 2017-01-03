#!/usr/bin/env bash

# We don't currently have any Codeception tests, so disable them.
DO_WP_CEPT=0;

# BuddyPress configuration.
export BP_DEVELOP_DIR=/tmp/buddypress
export BP_TESTS_DIR=/tmp/buddypress/tests/phpunit

# Install BuddyPress.
install-buddypress() {

	mkdir -p "$BP_DEVELOP_DIR"
	curl -s "https://downloads.wordpress.org/plugin/buddypress.$BP_VERSION.zip" > /tmp/buddypress.zip
	unzip /tmp/buddypress.zip -d "$BP_DEVELOP_DIR"
}

# Override commands.
wordpoints-dev-lib-config() {

	# Install BuddyPress for the PHPUnit pass.
	alias setup-phpunit='install-buddypress; setup-phpunit; ln -s "$BP_DEVELOP_DIR"/src "$WP_CORE_DIR"/wp-content/plugins/buddypress';
}

# EOF
