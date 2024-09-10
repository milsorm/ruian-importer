.phony: all download clean

all: download

download:
	php -f tools/importer.php -- -d

clean:

