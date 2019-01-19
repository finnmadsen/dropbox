FROM debian:buster

LABEL "maintainer"="Finn Madsen"
LABEL "version"="1.0 / 2018-12-31"

ENV DEBIAN_FRONTEND noninteractive

# Create service account and set permissions.
RUN useradd -d /dbox -c "Internal Dropbox Account" -s /usr/sbin/nologin dropbox \
    && mkdir -p /dbox/.dropbox /dbox/.dropbox-dist /dbox/Dropbox /dbox/base /dbox/dcontrol \
    && chown -R dropbox /dbox

# Download & install required applications
RUN echo deb http://ftp.de.debian.org/debian testing main >> /etc/sources.list \
    && apt-get -qqy update \
	&& apt-get -qqy install wget python python3.6 sudo procps \
	&& wget -nv -O /dbox/base/dropbox.tar.gz "https://www.dropbox.com/download?plat=lnx.x86_64" \
	&& wget -nv -O /dbox/dropbox.py "https://www.dropbox.com/download?dl=packages/dropbox.py" \
	&& wget -O /usr/local/bin/dumb-init https://github.com/Yelp/dumb-init/releases/download/v1.2.2/dumb-init_1.2.2_amd64 \
	&& chmod +x /usr/local/bin/dumb-init \
	&& apt-get install -y locales \
	&& apt-get -qqy autoclean \
    && apt-get install -y nginx php-fpm \
	&& chmod +x /usr/local/bin/dumb-init \
	&& ln -s /usr/bin/python3.6 /usr/bin/python3 \
    && rm /usr/bin/python \
    && ln -s /usr/bin/python3 /usr/bin/python

# Install script for managing dropbox init.
COPY server /dbox/
COPY dcontrol/ /dbox/dcontrol/
COPY dropbox /usr/local/bin/

# Configure nginx and php-fpm
COPY etc/ /etc/
RUN rm /etc/php/7.3/fpm/pool.d/www.conf \
    && rm /etc/nginx/sites-available/default \
    && rm /etc/nginx/sites-enabled/default \
    && mkdir -p /run/php \
    && cd /etc/nginx/sites-enabled \
    && ln -s ../sites-available/* . \
    && sed -i -- 's/www-data/dropbox/g' /etc/nginx/nginx.conf

RUN chmod +x /dbox/server /usr/local/bin/dropbox /dbox/dropbox.py

VOLUME ["/dbox/.dropbox", "/dbox/Dropbox"]

# Dropbox Lan-sync
EXPOSE 17500

# Set workdir
WORKDIR /dbox/Dropbox

ENTRYPOINT ["/usr/local/bin/dumb-init", "--"]
CMD ["/dbox/server"]
