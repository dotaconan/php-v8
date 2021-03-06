# GitHub release

1. Make sure current state is ready for release:
  * All relevant PR merged and issues closed.
  * Build passed.
2. Prepare release notes by creating release draft on github.
3. Update `PHP_V8_VERSION` to have desired version and set `PHP_V8_REVISION` to `release` in `php_v8.h`.
4. Run `./scripts/refresh-package-xml.php -f` to update `package.xml` with proper `php-v8` version and update directories
   and files tree.
5. Update `package.xml` `<notes>` with release notes. Keep eye on special characters to properly escape them,
   e.g. `>` should be written as `&gt;` instead.
6. Commit all changes with `Prepare X.Y.Z release` commit message.
7. Push this commit and make sure it will pass the build.
8. Tag it with `vX.Y.Z` tag and push. Create github release from a draft prepared in step above.
9. Close relevant milestone, if any.
10. Run `./scripts/subsplit.sh` to update `php-v8-stubs` which are available in a separate read-only repository to match
    packagist and composer expectations. 

# PECL release 

1. Run `pecl package` in your build machine (it's normally vagrant box used for `php-v8` development). It should create
   `v8-X.Y.Z.tgz` file.
2. Log in to PECL and upload file from previous step at https://pecl.php.net/release-upload.php. Verify that release info
   is accurate and confirm release.  

# Ubuntu PPA release

1. Copy targeted `libv8-X.Y` build to `php` ppa without rebuild, just copy.
2. Make sure you have proper PHP and php-v8 PPA dependencies set in https://launchpad.net/~pinepain/+archive/ubuntu/php-v8/+edit-dependencies
3. Make sure you have proper `php-v8` version set in `packaging/Dockerfile` under `V8` constant. 
4. In `packaging/php-v8/Makefile` set proper `VERSION=X.Y.Z`
5. Make sure you have valid `libv8` dependency in `packaging/php-v8/debian/control` file.
6. Commit changes with `build php-v8` commit message and wait until libv8 PPA build done.
7. Copy `php-v8` packages to `pinepain/php` PPA, do not rebuild, just copy.
8. After they get copied, feels free to remove **old** `libv8` packages from `pinepain/php` ppa.

# macOS Homebrew release

1. Update `php7*-v8` formulae **one by one** to have proper `depends_on 'v8@X.Y'`
   and `v8_prefix=Formula['v8@X.Y'].opt_prefix` values.
2. If you want to rebuild existent version, add/increment `revision` in formula body.
3. If version has already been published to bintray and you absolutely sure it needs to be re-built without revision.
   bump, you will need to delete such version from bintray first.

# After all

1. Update [js-sandbox](https://github.com/pinepain/js-sandbox)/`.travis.yml` and `.scrutinizer.yml`
   to refer to new `php-v8` version and to relevant `libv8` PPA and packages. 
2. Update `PHP_V8_VERSION` to the next version and set `PHP_V8_REVISION` to `dev` in `php_v8.h`.
3. Commit changes with `Back to dev [skip ci]` message and push them to master.
