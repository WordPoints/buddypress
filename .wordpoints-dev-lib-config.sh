#!/usr/bin/env bash

# We don't currently have any Codeception tests, so disable them.
DO_WP_CEPT=0;

# BuddyPress configuration.
export BP_DEVELOP_DIR=/tmp/buddypress
export BP_TESTS_DIR=/tmp/buddypress/tests/phpunit

# Install BuddyPress.
install-buddypress() {

	mkdir -p "$WP_DEVELOP_DIR"
	curl -L "https://github.com/buddypress/BuddyPress/archive/$BP_VERSION.tar.gz" \
		| tar xvz --strip-components=1 -C "$BP_DEVELOP_DIR"
	ln -s  "$BP_DEVELOP_DIR"/src "$WP_CORE_DIR"/wp-content/plugins/buddypress
}

# Override commands.
wordpoints-dev-lib-config() {

	# Install BuddyPress for the PHPUnit pass.
	alias setup-phpunit="setup-phpunit; install-buddypress";
}

# EOF
