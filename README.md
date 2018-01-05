Value objects
=============

Simple value objects. 

- E-mail
- URL

Helper class
============

StringNormalizer
----------------

Simple class for normalizing string inputs. It provides three simple methods:

- normalize - converts whitespaces and empty strings to `null`
- normalizeMandatory - same as normalize, but throws exception on `null` result
- normalizeRecursive - normalize for arrays
