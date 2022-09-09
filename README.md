# DSM Runtime

This is a fork of edmondscommerce/doctrine-static-meta

It has been updated lightly so that it can run with PHP 8.1

The main thing is that all code generation features have been removed. Currently the code generation dependency that 
edmondscommerce/doctrine-static-meta uses has been abandoned and all code using that dependency needs to be fully 
recreated.

In the meantime, this runtime library can be used as a drop in replacement for edmondscommerce/doctrine-static-meta 
and should provide all the functionality required for normal operations.

This has not been tested thoroughly at all, you must ensure your own project tests are thorough and will catch any 
regressions caused by switching to this alternative version