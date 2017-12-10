#!/bin/bash
sudo pip install -r docs/requirements.txt && \
    cd docs/php-form && \
    mkdocs build && \
    tar -zcvf phpform.tar.gz -C site . && \
    curl -X POST -H "Content-Type: multipart/form-data" -H "Api-Key: ${ALEXANDRIA_APIKEY}" -F "archive=@phpform.tar.gz" https://alexandriadocs.io/api/v1/projects/upload/
