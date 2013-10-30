SELECT vicdes.*, segments.*, mileage.* FROM VicDescriptions as vicdes
inner join VehicleSegments as segments 
inner join Mileage as mileage
WHERE vicdes.VIC_Body = '__VIC_Body__' 
and vicdes.VIC_Series = '__VIC_Series__' 
and vicdes.VIC_Year = '__VIC_Year__' 
and vicdes.VIC_Make = '__VIC_Make__' 
and vicdes.BookFlag = '__BookFlag__' 
and vicdes.Period = '__Period__'
and segments.VehicleSegmentID = vicdes.VehicleSegmentCode
and segments.Period = vicdes.Period
and mileage.VIC_Year = vicdes.VIC_Year
and mileage.MileageClass = vicdes.MileageClass
and mileage.Period = vicdes.Period
and '__Mileage__' >= mileage.Range_Low 
and '__Mileage__' <= mileage.Range_High 