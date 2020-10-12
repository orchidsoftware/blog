---
extends: _layouts.post
section: content
title: What stack does Orchid use?
date: 2020-10-12
description: A solid base allows it to exist for a long time without drastic changes.
---

There are a lot of different stacks in trend right now for building an application. Every year or two, a new product appears that causes a lot of hype on the net and people to rush to rewrite their projects.

There are a lot of different stacks in trend right now for building an application. Every year or two, a new product appears that causes a lot of hype on the net and people to rush to rewrite their projects.

But the laravel Orchid administration panel is in no hurry to make changes.
Does not participate in page building:

- React 
- Vue
- Tailwind css
- Alpine.js
- Livewire

It may seem that this is some old product. Indeed, the first public version was published in 2016. One of the factors that we have been around for so long is the principle of "don't run after the crowd."

#### There is such an interesting but controversial term as "The Hype Cycle".

![noize](/assets/img/lasting-stack/gartner_hype_cycle.svg)

- First, all blogs and famous people in the community talk about new technology.
- Users start to build new projects with it or try to build into existing ones.
- Interest on the part of public figures is fading away. Developers are beginning to face problems that can only be solved by major releases that are dragging on.
- People understand the strong and weak side. Technology begins to be applied in a narrower range of tasks
- The technology occupies a niche market and is growing slowly.

Does this sound familiar to you? I've seen people post in `React`, but after tweeting:

![noize](/assets/img/lasting-stack/twit.png)

Let's try `Vue` on real projects, then abandon it in favor
`Alpine.js` etc. This is not really a need. This is a trend!

#### Build a product during a trend blizzard

When I released the 0.x version, they used `jQuery`, and the most popular request was the conversion to `Vue`. Then I fell for this bait and began to rewrite the ready-made working code using the rapidly gaining popularity framework. After a few sleepless nights, the work was ready.
The public reaction was, "Oh cool! Another technology was rewritten to Vue," and that's it!
From this, there were no more users, since the offered functions have not changed. There are also no more change requests.

![backend-vs-frontend](/assets/img/lasting-stack/backend-vs-frontend.png)

In place of this, I received modern technology that took even more time to maintain it. Since first I had to do the work on `laravel`, and then continue` vue`.

This separation works great for a full-time job. One team worked on `PHP`, and the other on` JS` But this is an open and free product, where enthusiasts make changes in their free time. Now, for minor edits, more knowledge and skills were required from a person.

It was obvious that this was not very suitable for us at such a slow pace of work. Therefore, we drew attention to more classic `JS` frameworks, the purpose of which is not to convert `JSON` into `DOM` elements. To supplement an existing page, this choice was `Stimulus` from the `Ruby on rails` and` Basecamp` teams. At the same time, retaining the advantage of fast page loads. This allowed us to abandon the use of `API` and use the familiar `Blade`, introducing dynamic behavior only slightly.

In 2020, again, faced with questions, but let's change everything to `Livewire`, and now I demand clear justifications of what advantages we will get. Over the years of development, I tried many competitors, saw how they were written about on `laravel-news.com`, discussed `twitter`, etc.

But most of them did not last even a year. Following ever-changing trends, using inappropriate technologies, and fatigued developers were the main factors behind stopping development. Of course, there are exceptions in the form of the official `Nova` package, but at least two full-time developers working on it.


I'm sure there will be many more coming out soon.
Administration panels on TALL stack. But before using them,
think that they may not exist for a year. This solves the same problems as before. After all, what's the difference what is used as a CSS solution in the `Bootstrap` or `Bulma` admin area if you don't need to know them in order to use them.

