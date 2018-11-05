FROM nginx:latest

RUN apt-get update && apt-get upgrade -y && apt-get install -y curl python2.7 gnupg2 lsb-release

COPY nginx-conf /etc/nginx/conf.d