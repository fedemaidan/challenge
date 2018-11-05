# Api doc

Curl examples of endpoints:


1. GET team

       curl 'http://localhost:9000/index.php/team' -H \
       'Accept: application/json, text/plain, */*' -H  \
       'Origin: http://localhost:3000' -H \
       'Connection: keep-alive'

2. POST team

       curl 'http://localhost:9000/index.php/team' -H \
       'Accept: application/json, text/plain, */*' -H \
       'Content-Type: multipart/form-data' -H \
       'Origin: http://localhost:3000' -H 'Connection: keep-alive' \
        --data '{"name":"New team"}'

3. PUT team

        curl 'http://localhost:9000/index.php/team/$$$$ID$$$$$$' -X PUT -H \
       'Accept: application/json, text/plain, */*' -H \
       'Content-Type: multipart/form-data' -H  -H 'Connection: keep-alive' \
        --data '{"name":"Updated Name"}'

 4. DELETE team

        curl 'http://localhost:9000/index.php/team/$$$$ID$$$$$$' -X DELETE -H \
        'Accept: application/json, text/plain, */*' -H \
        'Content-Type: multipart/form-data' -H \
        'Connection: keep-alive'

 5. PUT player

        curl 'http://localhost:9000/index.php/player/$$$ID$$$$' -X PUT -H \
        'Accept: application/json, text/plain, */*' -H \
        'Content-Type: multipart/form-data' -H \
        'Connection: keep-alive'\
          --data '{"id":"tcQf18","first_name":"Phillipss","last_name":"Torres","speed":2,"strength":20,"agility":3,"is_starter":true}'








