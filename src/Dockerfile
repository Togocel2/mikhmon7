FROM php:7.4-cli-alpine
RUN apk update
RUN apk install git
RUN git clone https://github.com/Togocel2/mikhmon7 src
WORKDIR src
ENTRYPOINT ["php"]
CMD ["-S", "0.0.0.0:80", "-t", "/src/src/"]