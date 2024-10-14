# Psiconnea API Archetype

Laravel APIs archetype.

This archetype has been built following this guide: [https://psiconneasense.atlassian.net/wiki/spaces/PsiconneaT/pages/166330389/Archetype+Laravel+API](https://psiconneasense.atlassian.net/wiki/spaces/PsiconneaT/pages/166330389/Archetype+Laravel+API)

The Confluence guide provided allows understanding the structure of Laravel APIs built with **Hexagonal Architecture**. The guide also includes some consensus on programming practices, such as the base configuration of this archetype.

This project uses [https://github.com/openzipkin/b3-propagation#traceid-1](B3-Propagation) for the logs trace.

## Local Installation
Build the local **.env** based on the *.env.example*.

After this, we install composer:
```sh
composer i
```

We run the project:
```sh
composer run-bg-dev
```

## API Development Phases
1. Creation of the  **OpenApi** in the **api_definition.yml** file.
2. Creation of **feature test** and **unit test**. Using *osteel/openapi-httpfoundation-testing* for the *feature test*.
3. Define entities.
4. Develop.
5. Use of the **linter duster**, the previously configured **test** and **PhpStan**.
6. Write modifications in **changelog.md**.
