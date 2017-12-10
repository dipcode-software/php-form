#!/bin/sh
pip install -r docs/requirements.txt
cd docs/php-form
mkdocs build
tar -zcvf phpform.tar.gz -C site .
curl -X POST -H "Content-Type: multipart/form-data" -H "Api-Key: ${1}" -F "archive=@phpform.tar.gz" https://alexandriadocs.io/api/v1/projects/upload/
rm phpform.tar.gz
