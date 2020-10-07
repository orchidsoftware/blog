---
extends: _layouts.post
section: content
title: Comparison of administration panels
date: 2019-03-03
description: Comparing the complexity of the code for different admin panels in laravel
---


In 2017, [Taylor Otwell](http://medium.com/@taylorotwell) published several articles, not comparing features or convenience, but the code results for various frameworks, where Laravel was the clear favorite.

[Average class size comparison](http://medium.com/@taylorotwell/framework-average-class-size-comparison-63722a8ed9cf)

> Framework Average Class Size Comparison ... I published some average method complexity statistics yesterday. One rebuttal to those statistics was that Laravel's ...



[and code complexity comparison](http://medium.com/@taylorotwell/measuring-code-complexity-64356da605f9)


> Framework Code Complexity Comparison ... Last week, as I was refactoring and cleaning Laravel for the 5.4 release, Graham Campbell showed me some code complexity ...

The measurements were taken using the [phploc](https://github.com/sebastianbergmann/phploc) tool. I think it would be a good idea to do the same analysis for the administration packages. **Less is better.**

**Backpack:**

* 17 834 lines
* 23 medium long,
* 9.51 average class difficulty

**Nova:**

* 19 701 lines
* 10 medium length
* 3.26 average class difficulty

**SleepingOwl:**

* 27 256 lines
* 16 medium long
* 4.81 average class difficulty

**Orchid:**

* 12,753 lines
* 10 medium length
* 2.68 average class difficulty

**Voyager:**

* 10,744 lines
* 11 medium long
* 4.59 average class difficulty

**Z-song/laravel-admin:**

* 26,292 lines
* 22 medium length
* 6.40 average class difficulty


Measurements were carried out in the `src` directory, only for files with the `.php` extension, the latest versions of packages as of March 3, 2019, were used.
