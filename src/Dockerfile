FROM php:cli-alpine
RUN apk update
RUN apk add curl
RUN apk add git
RUN git clone https://github.com/Togocel2/mikhmon7 src
WORKDIR src
ENTRYPOINT ["php"]
CMD ["-S", "0.0.0.0:80", "-t", "/src/src/"]