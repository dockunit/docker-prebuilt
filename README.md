# Dockunit Pre-built Dockerfiles

[Dockunit](https://github.com/tlovett1/dockunit) is a tool that allows you containerize your unit tests. No longer must software developers create environments to run test suites. Dockunit allows you to define a list of test environments as Docker images to run your tests. In combination with Dockunit, [Dockunit.io](http://dockunit.io) can be used to achieve continuous containerized integration with your projects.

This repository contains handy pre-built Docker images for use with Dockunit. If you don't like these, you can always create your own. Each pre-built image's Dockerfile is contained here.


### Steps to use an image:

1. Download and setup dockunit via [npm](https://www.npmjs.com/dockunit)
2. Add a `Dockunit.json` to your Github repository. There are a number of [examples](https://www.npmjs.com/package/dockunit#dockunit-json-examples) you can start with. Reference one of these images in your `Dockunit.json` file.
3. Run your software unit tests by running the `dockunit` command.
4. Create a free account on Dockunit.io and add a project that connects to your Github repo.