#!/usr/bin/env bash

# Install BuddyPress
install-buddypress() {

	export BP_DEVELOP_DIR=/tmp/buddypress
	export BP_TESTS_DIR=/tmp/buddypress/tests/phpunit

	mkdir -p "$WP_DEVELOP_DIR"
	curl -L "https://github.com/buddypress/BuddyPress/archive/$BP_VERSION.tar.gz" \
		| tar xvz --strip-components=1 -C "$BP_DEVELOP_DIR"
	ln -s  "$BP_DEVELOP_DIR"/src "$WP_CORE_DIR"/wp-content/plugins/buddypress
}

# Install BuddyPress for the PHPUnit pass.
alias setup-phpunit="setup-phpunit; install-buddypress";

# EOF
