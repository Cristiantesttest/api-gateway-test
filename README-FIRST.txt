The algorithm used is simple and efficient. I preferred to use core Laravel mechanisms, for better performance and to keep everything 
simple. In the following I will briefly explain how it works:

The request is launched on the /relay route for which a middleware was created. This middleware takes care of logging and analyzing 
performance data. I preferred to store all the metrics through Laravel Logging and for the Counter and the total request time I preferred 
to use Cache, because it is fast and efficient in this case, easy to manage being key-value based. The metric logs are stored in 
storage/logs/metric.log and for the Cache I used as keys a combination of suggestive name and endpoint/path. Eg: request_count_apirelay 
and requests_time_apirelay. I also made a minimum preparation for JWT authentication by putting a variable in .ENV according to which a 
middleware is created to check which type of authentication is preferred. The logging and metrics components are modular.

By default any test can be done with 40 requests in a shot.