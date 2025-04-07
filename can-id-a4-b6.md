| ID  | MSG                     | Bytes | Ascii | Description                                                                                    |
|-----|-------------------------|-------|-------|------------------------------------------------------------------------------------------------|
| 261 | 54 45 53 54 20 20 20 20 | 8     | Oui   | First line of content on FIS                                                                   |
| 263 | 54 45 53 54 20 20 20 20 | 8     | Oui   | Second line of content on FIS                                                                  |
| 265 | 54 45 53 54 20 20 20 20 | 8     | Oui   | First line of content on FIS (high priority / used by phone)                                   |
| 267 | 54 45 53 54 20 20 20 20 | 8     | Oui   | Second line of content on FIS (high priority / used by phone)                                  |
|     |                         |       |       |                                                                                                |
| 271 | 10                      | 1     | Non   | Position of the ignition key; 10 means key out of ignition                                     |
| 351 | 00 6E 10 AE 09 76 75 05 | 8     | Non   | Byte 0, 00 ahead / 01 backwards                                                                |
| 351 | 00 6E 10 AE 09 76 75 05 | 8     | Non   | Byte 1 en 2, speed; swap byte1 and byte2, 106E. Decimal / 200 = 21Km/h                         |
| 351 | 00 6E 10 AE 09 76 75 05 | 8     | Non   | Byte 4 en 5 Wheel pulse; calculate distance travelled                                          |
| 353 | 20 F5 0C 65 80 6F       | 6     | Non   | Rpm; swap byte1 and byte2, 0CF5. Decimal / 4 = 829 rpm                                         |
| 353 | 20 F5 0C 65 80 6F       | 6     | Non   | Byte 3 indicates the Coolant Temperature in degrees Fahrenheit. (-32 / 1,8 = Celcius)          |
|     |                         |       |       |                                                                                                |
| 428 | 16 01 00 00 00 00 00 00 | 8     | Non   | Ring-ID, KI zoekt Rns-e. Reply with; 436 [1A] (on phone), of 428 [08] 01 00 00 00 00           |
| 436 | 1A 01 00 00 00 00 00 00 | 8     | Non   | Ring-ID, KI is looking for phone. Reply with; 43A [08] 01 00 00 00 00                          |
| 436 | 16 02 80 00 00 00       | 6     | Non   | Rns-e first sign on the ring                                                                   |
| 43A | 1A 02 80 00 00 00       | 6     | Non   | Phone initial notification on the ring                                                         |
|     |                         |       |       |                                                                                                |
| 461 | 37 30 01 40 00 00       | 6     | Non   | Up button Rns-e                                                                                |
| 461 | 37 30 01 80 00 00       | 6     | Non   | Down button Rns-e                                                                              |
| 461 | 37 30 01 00 40 01       | 6     | Non   | Left button Rns-e                                                                              |
| 461 | 37 30 01 00 20 01       | 6     | Non   | Right button Rns-e                                                                             |
| 461 | 37 30 01 01 00 00       | 6     | Non   | Previous button Rns-e                                                                          |
| 461 | 37 30 01 02 00 00       | 6     | Non   | Next button Rns-e                                                                              |
| 461 | 37 30 01 00 10 00       | 6     | Non   | Selection button (big round) Rns-e                                                             |
| 461 | 37 30 01 00 02 00       | 6     | Non   | Return button Rns-e                                                                            |
| 461 | 37 30 01 00 01 00       | 6     | Non   | Setup button Rns-e                                                                             |
| 5C0 | 39 00                   | 2     | Non   | Passive state Multifunction steering wheel                                                     |
| 5C0 | 39 02                   | 2     | Non   | Left button Multifunction steering wheel                                                       |
| 5C0 | 39 03                   | 2     | Non   | Right button Multifunction steering wheel                                                      |
| 5C0 | 39 04                   | 2     | Non   | Up button Multifunction steering wheel                                                         |
| 5C0 | 39 05                   | 2     | Non   | Down button Multifunction steering wheel                                                       |
| 5C0 | 3A 1C                   | 2     | Non   | Mode button Multifunction steering wheel                                                       |
|     |                         |       |       |                                                                                                |
| 602 | 89 12 30 00 00 00 00 00 | 8     | Non   | Activates the Tv/Video option in your RNS-E                                                    |
| 604 | 81 00 00 00 00 00 00 00 | 8     | Non   | Always stays the same                                                                          |
| 621 | 10 49 3C                | 3     | Non   | Byte 0 responds to Driver's door and engine lid                                                |
| 621 | 10 49 3C                | 3     | Non   | Byte 1 en 2 increases when contact is passive. LSB,MSB                                         |
| 623 | 00 14 25 54 12 03 20 16 | 8     | Non   | Time / Date; xx HH MM SS DD MM YY YY                                                           |
| 627 | 80 3a 3a 3a 3a 28 28 28 | 8     | Non   | Byte 0 responds to Driver's door, 0 Closed / 8 open                                            |
| 627 | 80 3a 3a 3a 3a 28 28 28 | 8     | Non   | Byte 0 (2e Digit) responds to status FIS screen; 0, default, 1 registration FIS, 4 is P (Gear) |
| 627 | 80 3a 3a 3a 3a 28 28 28 | 8     | Non   | Byte 1tm7 standaard 28. 1tm4 becomes 3A when FIS is active. All 00 when no FIS activity        |
| 635 | 39 00 10                | 3     | Non   | Relief, byte1; 00 from / 64 at.                                                                |
| 635 | 39 00 10                | 3     | Non   | Byte 2; dash lighting dimming percentage                                                       |
| 651 | C0 14 61 20 14 40       | 6     | Non   | Always the same position                                                                       |
| 653 | 01 01 14                | 3     | Non   | Always the same position                                                                       |
| 661 | 83 01 12 37 00 00 00 00 | 8     | Non   | Rns-e On, byte 2 (37) indicates the mode, in this case VIDEO                                   |
| 665 | 6F 20 00 00 30 00 20    | 7     | Non   | This message is sent to indicate phone activity                                                |
|     |                         |       |       |                                                                                                |
| 6C0 |                         | 8     | Oui   | Used for Rns-e to FIS screen (explained in other post)                                         |
| 6C1 |                         | 8     | Oui   | Used for Rns-e to FIS screen (explained in other post)                                         |
| 6C4 | A0 0F 8A FF 4A FF       | 6     | Non   | Keep alive request from KI for Phone                                                           |
| 6C5 | A3                      | 1     | Non   | Answering keep alive request Phone to KI                                                       |
