SELECT vin.*, state.*
FROM VinPrefix as vin
inner join States as state
WHERE vin.VinPrefix LIKE '__VinPrefix__' 
and vin.Period = '__Period__'
and state.StateCode = '__STATE__' 
and vin.Period = state.Period
