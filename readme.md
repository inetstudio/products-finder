# Elasticsearch

````
curl -X PUT "localhost:9200/app_index_products_finder" -H 'Content-Type: application/json' -d'
{
   "settings": {
    "analysis": {
      "filter": {
        "ru_stop": {
          "type": "stop",
          "stopwords": "_russian_"
        },
        "ru_stemmer": {
          "type": "stemmer",
          "language": "russian"
        }     
      },
      "analyzer": {
        "default": {
          "char_filter": [
            "html_strip"
          ],
          "tokenizer": "standard",
          "filter": [
            "lowercase",
            "ru_stop",
            "ru_stemmer"
          ]
        }   
      }
    }
  },
   "mappings":{
      "properties":{
          "type": {
             "type":"keyword"
          },            
          "id":{
             "type":"integer"
          },            
          "brand":{
             "type":"text"
          },
          "series":{
             "type":"text"
          },
          "title":{
             "type":"text"
          },
          "description":{
             "type":"text"
          },                                                
          "benefits":{
             "type":"text"
          },
          "how_to_use":{
             "type":"text"
          },
          "search_field":{
             "type":"text"
          },            
          "classifiers":{
             "type":"nested"
          }
       } 
   }
}
'
````
