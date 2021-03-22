## A PHP app that allows users to perform a Google search and get the rank positions of a website

Visit https://search.abirhossain.com.au to see demo

### Search Options

1. **Search Keywords**: The keywords to search (e.g. `creditorwatch`)


2. **Target URL**: The URL to get rank positions for (e.g. `creditorwatch.com.au`)


3. **Include Omitted results**: Whether to include Google's [Omitted Results](https://support.google.com/gsa/answer/2710009?hl=en) in the search, which are excluded by default

### Logic

The app extracts the domain (e.g. `creditorwatch.com.au`) from a given URL (e.g. `https://www.creditorwatch.com.au`) and then uses that domain to do a `contains` searches against the search result links

This allows us to get the rank positions of all pages within a domain (e.g. `https://www.creditorwatch.com.au/about`) that show up in the search results

---

## Get Started

This Search Rankings App can be developed, debugged and tested locally using Docker with Xdebug.

### Prerequisites

You will need the following applications installed before starting:

1. [Docker](https://docs.docker.com/install/) -- For first time installation and setup, please follow the instructions at [Docker Desktop](https://docs.docker.com/desktop/)

2. [Cmder](https://cmder.net/) -- Optional but recommended. This is a Portable console emulator for Windows users only. On Macs, you can use Terminal instead.

---

## Quick Start

```
# Change directory to the repository
cd search-rankings-api

# Copy the environments file and edit your variables accordingly
cp .env.dist .env

# Build docker image and run app locally
docker-compose up --build
```

After both the `php` and `webserver` containers start, the app should be running at [http://localhost:8000](http://localhost:8000)

The `app` directory will be mounted within the `/app` directory within the container.
This means any files created/edited from either the host machine or container will be reflected in both realtime.

If you want to run this app directly on your machine, you will need the following system packages installed:

```
1. libyaml
2. PHP yaml extension (pecl install yaml)
```

---

## File Structure

The app has been structured in an MVC pattern (without the models as there's no database)

	.
	├── app
	|   ├── config              # Configuration for the application
	|   ├── src
	|      ├── Controller       # Controllers
	|      ├── Helpers          # Helper classes such as Request and Response
	|      ├── SearchClients    # Client classes for making search engine queries
	|      └── View             # Views
	|   ├── static              # Static files
	|   ├── tests               # Unit tests
	|   ├── Makefile            # A Makefile with frequently used commands
	|   └── index.php           # Application entrypoint
	└── ...

---

## Design Patterns

### Adapter

The adapter pattern was used for the following reasons:

1. It allows incompatible interfaces to collaborate through abstraction


2. If sometime later, the CEO wants to search on another search engine (such as Bing), this pattern allows us to easily add new search engines without a big refactor


3. Specifically here it allows a specific search engine class such as "GoogleApi" (Adaptee) to define its own interface for that specific search engine API without having to worry about compatibility for any clients using it. A wrapper class "'GoogleSearchClient" (Adapter)  wraps the specific search engine class and allows client objects to have a unified interface with interacting with any search engine APIs

### Facade

Although not specifically used, it would make sense to use a Facade design pattern for providing simple unified method for making search queries. Such a method would hide all the complexities of making the requests and interacting with the search engine APIs (Authentication, 3rd party API calls, etc)

### Dependency Injection

As much as reasonable, I have tried to use dependency injection through constructors to make unit testing easier

### Mocks and Stubs

I have used mocks and stubs wherever it made sense to use them (such as external API calls). As a result, none of the unit tests depend on any external systems

---
## Unit Testing

The AAA [(Arrange, Act, Assert)](https://automationpanda.com/2020/07/07/arrange-act-assert-a-pattern-for-writing-good-tests/) pattern has been used to write the unit tests

Run `make test` or `phpunit tests` within the `/app` directory to run all the unit tests

---

## Shortcuts

Due to time-constraints a number of shortcuts were taken. Here are the things I would do differently in a production environment

### 1. Error Handling and Edge cases

The code was written based on a happy-path assumption that valid function arguments and return values are valid.

It assumes that a user will visit the homepage form and enter valid input

In a production-app, I would write the code more defensively with a zero-trust approach, checking function arguments and return values for validity and using error-handling techniques such as throwing exceptions where appropriate and using try-catch blocks

The app also does not account for network issues

### 2. Clean up Unit tests. Add Regression and Integration Testing

I would take more time to clean up and structure the unit tests + fixtures better, adding comments to them. I would also set up regression and integration testing.

### 3. Write more performant code

I would spend more time thinking about time/space complexity of the code

### 4. CI/CD pipeline

I would create a CI/CD pipeline using bitbucket pipelines that deploys the app to AWS

### 5. IaC using Terraform

I would write Terraform code to define all resources I want to provision. This would typically be a multi-account setup where each environment (qa, stg and prod) are deployed into separate AWS accounts

### 6. Use a framework and environment variables

I would use a framework like Symfony and environment variables rather than passing around a global object to bootstrap app config

---

### All `make` commands

| Command | Action |
| ------- | ------ |
| `lint` | Run the linter to verify code style. |
| `test` | Run the test suite. |
