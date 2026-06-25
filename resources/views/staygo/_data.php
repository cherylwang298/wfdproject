<?php
// _data.php — shared dummy data

$hotels = [
  ['id'=>1,'name'=>'Azure Cliffside Villa','location'=>'Santorini, Greece','type'=>'villa','price'=>450,'rating'=>4.96,'badge'=>'Top Pick','img'=>'https://lh3.googleusercontent.com/aida-public/AB6AXuA1dfhgJlmAA87_gyN0dgN0QJnLl49h203ynWJJOBxHEDrWlUNzzNs3nr4690eC2H0DZ10Zem6Rv3O0frUXluG1A2GzCp8wzhzc-G0KoBzvHYdJ2CRw9qTBLPjBtoXSIoxXktRP0OfgWjdZrwXZgauVA-76uvyeYRF7GJpDNw3bsINgbEfpE-yYOOTdijVUqAPdp7M55zcGn_0Lrb6pjyOHkZ414mKsRXkAiHbjl7hxB_ozeLd5-JF4knOTi-c9e7CDaw1qJXkEzEA'],
  ['id'=>2,'name'=>'The Cove Hotel','location'=>'Maui, Hawaii','type'=>'hotel','price'=>280,'rating'=>4.8,'badge'=>null,'img'=>'https://lh3.googleusercontent.com/aida-public/AB6AXuCfcpvf7dJaoBKsy8L-HjnOmyrHrP457DXddAmbJtJpgjEg9hhPdiEPcEgkcFpwTqFG0MZpamkp8mInZ9Cje7jnrzRlASN7lTOqOiJOpXuc0361G74pBECWPZUdBasuZfZdJ23dcL424VVQuS5M0q5FqRlLRvSJIuOEAEQpY7o0-rRgjOfOmDwnCBq3ETjRJNr_R1EKfH12aa4UD95p4FwmoWE2-IFgzD_b7CMwz2gAEmMP4WBVDXPWd1DrqMJW1DtMhlKxpBLsyQg'],
  ['id'=>3,'name'=>'Ubud Forest Cabin','location'=>'Bali, Indonesia','type'=>'cabin','price'=>120,'rating'=>4.7,'badge'=>'Popular','img'=>'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=600'],
  ['id'=>4,'name'=>'Parisian Luxury Suite','location'=>'Paris, France','type'=>'apartment','price'=>390,'rating'=>4.9,'badge'=>null,'img'=>'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=600'],
  ['id'=>5,'name'=>'Kyoto Ryokan Inn','location'=>'Kyoto, Japan','type'=>'hotel','price'=>210,'rating'=>4.85,'badge'=>'Cultural Pick','img'=>'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=600'],
  ['id'=>6,'name'=>'Amalfi Clifftop Villa','location'=>'Amalfi, Italy','type'=>'villa','price'=>620,'rating'=>4.97,'badge'=>'Luxury','img'=>'https://images.unsplash.com/photo-1534430480872-3498386e7856?w=600'],
  ['id'=>7,'name'=>'Reykjavik Northern Lights Lodge','location'=>'Reykjavik, Iceland','type'=>'cabin','price'=>175,'rating'=>4.75,'badge'=>null,'img'=>'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=600'],
  ['id'=>8,'name'=>'Dubai Marina Apartment','location'=>'Dubai, UAE','type'=>'apartment','price'=>310,'rating'=>4.88,'badge'=>'City View','img'=>'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600'],
  ['id'=>9,'name'=>'Maldives Overwater Bungalow','location'=>'Malé, Maldives','type'=>'villa','price'=>890,'rating'=>5.0,'badge'=>'Dream Stay','img'=>'https://images.unsplash.com/photo-1540202404-a2f29016b523?w=600'],
  ['id'=>10,'name'=>'Cape Town Ocean Lodge','location'=>'Cape Town, South Africa','type'=>'hotel','price'=>195,'rating'=>4.72,'badge'=>null,'img'=>'https://images.unsplash.com/photo-1580060839134-75a5edca2e99?w=600'],
  ['id'=>11,'name'=>'Swiss Alps Chalet','location'=>'Zermatt, Switzerland','type'=>'cabin','price'=>480,'rating'=>4.91,'badge'=>'Mountain View','img'=>'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=600'],
  ['id'=>12,'name'=>'Bangkok Sky Apartment','location'=>'Bangkok, Thailand','type'=>'apartment','price'=>95,'rating'=>4.65,'badge'=>null,'img'=>'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=600'],
];

$flights = [
  ['id'=>1,'airline'=>'Garuda Indonesia','code'=>'GA-874','from'=>'CGK','to'=>'HND','from_city'=>'Jakarta','to_city'=>'Tokyo','dep'=>'23:30','arr'=>'08:50','duration'=>'7h 20m','stops'=>0,'stop_code'=>null,'price'=>450,'class'=>'Economy','badge'=>null,'color'=>'blue'],
  ['id'=>2,'airline'=>'Japan Airlines','code'=>'JL-726','from'=>'CGK','to'=>'NRT','from_city'=>'Jakarta','to_city'=>'Tokyo','dep'=>'06:45','arr'=>'20:30','duration'=>'11h 45m','stops'=>1,'stop_code'=>'SIN','price'=>380,'class'=>'Economy','badge'=>'Cheapest','color'=>'red'],
  ['id'=>3,'airline'=>'Singapore Airlines','code'=>'SQ-952','from'=>'CGK','to'=>'HND','from_city'=>'Jakarta','to_city'=>'Tokyo','dep'=>'08:15','arr'=>'19:40','duration'=>'9h 25m','stops'=>1,'stop_code'=>'SIN','price'=>410,'class'=>'Economy','badge'=>null,'color'=>'purple'],
  ['id'=>4,'airline'=>'ANA','code'=>'NH-836','from'=>'CGK','to'=>'HND','from_city'=>'Jakarta','to_city'=>'Tokyo','dep'=>'14:00','arr'=>'23:15','duration'=>'7h 15m','stops'=>0,'stop_code'=>null,'price'=>520,'class'=>'Business','badge'=>'Fastest','color'=>'teal'],
  ['id'=>5,'airline'=>'Cathay Pacific','code'=>'CX-714','from'=>'CGK','to'=>'NRT','from_city'=>'Jakarta','to_city'=>'Tokyo','dep'=>'10:30','arr'=>'00:50','duration'=>'12h 20m','stops'=>1,'stop_code'=>'HKG','price'=>355,'class'=>'Economy','badge'=>null,'color'=>'green'],
  ['id'=>6,'airline'=>'Korean Air','code'=>'KE-628','from'=>'CGK','to'=>'ICN','from_city'=>'Jakarta','to_city'=>'Seoul','dep'=>'07:20','arr'=>'17:05','duration'=>'7h 45m','stops'=>0,'stop_code'=>null,'price'=>390,'class'=>'Economy','badge'=>null,'color'=>'orange'],
  ['id'=>7,'airline'=>'Garuda Indonesia','code'=>'GA-890','from'=>'CGK','to'=>'LHR','from_city'=>'Jakarta','to_city'=>'London','dep'=>'22:00','arr'=>'06:30','duration'=>'14h 30m','stops'=>1,'stop_code'=>'AMS','price'=>720,'class'=>'Economy','badge'=>'Best Value','color'=>'blue'],
  ['id'=>8,'airline'=>'Emirates','code'=>'EK-357','from'=>'CGK','to'=>'DXB','from_city'=>'Jakarta','to_city'=>'Dubai','dep'=>'02:35','arr'=>'07:10','duration'=>'8h 35m','stops'=>0,'stop_code'=>null,'price'=>510,'class'=>'Economy','badge'=>null,'color'=>'amber'],
  ['id'=>9,'airline'=>'Qantas','code'=>'QF-44','from'=>'CGK','to'=>'SYD','from_city'=>'Jakarta','to_city'=>'Sydney','dep'=>'11:50','arr'=>'22:25','duration'=>'6h 35m','stops'=>0,'stop_code'=>null,'price'=>290,'class'=>'Economy','badge'=>null,'color'=>'rose'],
  ['id'=>10,'airline'=>'Turkish Airlines','code'=>'TK-68','from'=>'CGK','to'=>'IST','from_city'=>'Jakarta','to_city'=>'Istanbul','dep'=>'01:15','arr'=>'09:40','duration'=>'16h 25m','stops'=>1,'stop_code'=>'KUL','price'=>640,'class'=>'Economy','badge'=>null,'color'=>'pink'],
];

$bookings = [
  ['id'=>'SG-2024-001','type'=>'hotel','name'=>'Azure Cliffside Villa','location'=>'Santorini, Greece','dates'=>'Dec 24 – Dec 31, 2024','guests'=>2,'price'=>3150,'status'=>'confirmed','img'=>'https://lh3.googleusercontent.com/aida-public/AB6AXuA1dfhgJlmAA87_gyN0dgN0QJnLl49h203ynWJJOBxHEDrWlUNzzNs3nr4690eC2H0DZ10Zem6Rv3O0frUXluG1A2GzCp8wzhzc-G0KoBzvHYdJ2CRw9qTBLPjBtoXSIoxXktRP0OfgWjdZrwXZgauVA-76uvyeYRF7GJpDNw3bsINgbEfpE-yYOOTdijVUqAPdp7M55zcGn_0Lrb6pjyOHkZ414mKsRXkAiHbjl7hxB_ozeLd5-JF4knOTi-c9e7CDaw1qJXkEzEA'],
  ['id'=>'SG-2024-002','type'=>'flight','name'=>'Jakarta → Tokyo','location'=>'Garuda Indonesia GA-874','dates'=>'Jan 15, 2025','guests'=>1,'price'=>450,'status'=>'confirmed','img'=>null],
  ['id'=>'SG-2024-003','type'=>'hotel','name'=>'Ubud Forest Cabin','location'=>'Bali, Indonesia','dates'=>'Feb 10 – Feb 14, 2025','guests'=>2,'price'=>480,'status'=>'upcoming','img'=>'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=600'],
  ['id'=>'SG-2024-004','type'=>'flight','name'=>'Jakarta → Sydney','location'=>'Qantas QF-44','dates'=>'Mar 5, 2025','guests'=>1,'price'=>290,'status'=>'upcoming','img'=>null],
  ['id'=>'SG-2023-008','type'=>'hotel','name'=>'Parisian Luxury Suite','location'=>'Paris, France','dates'=>'Sep 3 – Sep 8, 2024','guests'=>2,'price'=>1950,'status'=>'completed','img'=>'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=600'],
  ['id'=>'SG-2023-005','type'=>'flight','name'=>'Jakarta → Singapore','location'=>'Singapore Airlines SQ-952','dates'=>'Jul 12, 2024','guests'=>2,'price'=>820,'status'=>'completed','img'=>null],
];