/* =====================================================================
   Akhirrizal Photography — Image catalog
   Per-category Unsplash photo IDs sourced from topical searches:
     · Street          — "jakarta street night"
     · Human Interest  — "indonesian portrait" + curated documentary portraits
     · Landscape       — "indonesia volcano landscape" + curated highland frames
     · Outdoor         — curated travel / hike / adventure frames

   Each frame carries a Title and a short documentary Story (mock copy) plus
   optional Location and Date metadata. The category page renders the Title
   on hover and the full Story inside the PhotoSwipe side panel.

   To replace with real photographs, swap each `id` for the photographer's
   own Unsplash photo ID, and replace title/story/location/date with the
   real-life caption for that frame.
   ===================================================================== */

(function () {
  const RATIOS = {
    landscape: { w: 1600, h: 1067 },   // 3:2
    landscape4: { w: 1600, h: 1200 },  // 4:3
    portrait: { w: 1067, h: 1600 },    // 2:3
    tall: { w: 1280, h: 1600 },        // 4:5
    square: { w: 1400, h: 1400 },
    pano: { w: 1800, h: 900 },         // 2:1
  };

  const buildUrl = (id, w) =>
    `https://images.unsplash.com/photo-${id}?auto=format&fit=crop&w=${w}&q=80`;

  const make = (id, alt, ratio, title, story, location, date) => {
    const r = RATIOS[ratio] || RATIOS.landscape;
    return {
      id,
      alt,
      ratio,
      title,
      story,
      location: location || "",
      date: date || "",
      thumb: buildUrl(id, 900),
      display: buildUrl(id, 1600),
      full: buildUrl(id, 2400),
      width: r.w,
      height: r.h,
    };
  };

  const STREET = [
    make(
      "1659608927883-dc6d6f40ac1a",
      "Quiet sidewalk under a single warm streetlight",
      "portrait",
      "The Last Lamp on Jalan Sabang",
      "Past midnight on Jalan Sabang. The food stalls have folded for the night and there is only one streetlight left burning — the orange kind that turns the pavement into a stage.",
      "Jalan Sabang, Central Jakarta",
      "September 2024"
    ),
    make(
      "1633746792328-1e061f01e2cf",
      "Headlights blur down a wet Jakarta avenue at night",
      "landscape",
      "Rain on Sudirman",
      "Eight seconds at f/11 in the back of a stalled taxi. The city moves even when nothing is moving — the rain takes care of it.",
      "Jalan Jenderal Sudirman",
      "January 2024"
    ),
    make(
      "1656855566707-bc8ca6d81aea",
      "Motorbikes lined up outside a late-night warung",
      "landscape4",
      "Parking, Tebet",
      "Twenty motorbikes outside one warung, plates stacked in the kitchen window, every driver inside eating from the same nasi goreng pan. This is how the city actually eats.",
      "Tebet, South Jakarta",
      "February 2024"
    ),
    make(
      "1656855566586-65a283468fb3",
      "Night crowd gathering near a glowing shopfront",
      "portrait",
      "The Shopfront Glow",
      "A girl shows her phone to her friend; their faces are lit blue. Behind them the shop is lit gold. I'm not sure who is paying more attention to what.",
      "Senayan, Jakarta",
      "April 2024"
    ),
    make(
      "1691890087912-2163da621a93",
      "Long-exposure traffic streaks through downtown Jakarta",
      "landscape",
      "Six Lanes, One Direction",
      "Jakarta's traffic gets a bad reputation — but from above, at this hour, it looks like a river you almost want to step into.",
      "Slipi flyover, West Jakarta",
      "August 2024"
    ),
    make(
      "1715601583502-2b42bcbb02d6",
      "Lone figure crossing a neon-lit intersection",
      "tall",
      "Cross at the Beep",
      "Eleven at night and the crossing signal still beeps with the same urgency as noon. A single person walks across as if the city is finally his.",
      "Glodok, West Jakarta",
      "July 2024"
    ),
    make(
      "1640867627224-0d04cbe68f7b",
      "Street vendor at work in soft tungsten light",
      "portrait",
      "Mas Bambang's Window",
      "He has worked the same window for nineteen years. The tungsten bulb above his head has been replaced once. The wok has not.",
      "Pasar Santa, South Jakarta",
      "November 2023"
    ),
    make(
      "1650978889528-112a7caf52de",
      "Reflection of a city block in a rain puddle after dark",
      "landscape4",
      "The Puddle After the Rain",
      "Half an hour after the downpour, the city was already pretending nothing had happened. The puddle had not gotten the message yet.",
      "Menteng, Jakarta",
      "March 2024"
    ),
    make(
      "1493836512294-502baa1986e2",
      "Pedestrians slipping past a row of motorbikes",
      "landscape",
      "Between the Mirrors",
      "Three pedestrians threading the gap between parked motorbikes and a stalled van. Everyone moves at slightly different speeds. Nobody touches.",
      "Kota Tua, West Jakarta",
      "June 2024"
    ),
    make(
      "1551836022-d5d88e9218df",
      "Walking deeper into the alley between market stalls",
      "tall",
      "Deeper In",
      "The alley narrows and the light goes warmer with every step. Somewhere ahead a woman is laughing at something we will never hear.",
      "Blok M, South Jakarta",
      "May 2024"
    ),
    make(
      "1545324418-cc1a3fa10c00",
      "Quiet observation from the curbside at golden hour",
      "portrait",
      "Five Minutes Before Maghrib",
      "Golden hour in Jakarta is short — fifteen minutes, maybe twenty. I sat on this curb every evening for a week before this picture happened.",
      "Cikini, Central Jakarta",
      "October 2024"
    ),
    make(
      "1559113202-c916b8e44373",
      "Hands at work — small details of street life",
      "landscape",
      "Hands, Not Faces",
      "I never asked his name. He never asked mine. What I needed was the way his hands moved — that was the whole story.",
      "Pasar Baru, Jakarta",
      "August 2024"
    ),
  ];

  const HUMAN = [
    make(
      "1518725522904-4b3939358342",
      "Tranquil portrait in traditional dress",
      "portrait",
      "Pak Wayan, in His Father's Clothes",
      "He wore his father's wedding clothes for the festival. \"Same size,\" he said. \"Same shoulders. Different country, now.\"",
      "Ubud, Bali",
      "December 2023"
    ),
    make(
      "1516011362164-3095a82b0af9",
      "Warm portrait of a man wearing a turban, smiling softly",
      "portrait",
      "Hassan, at the Door",
      "Hassan opens his door for me every Friday morning. I have never refused his tea. I have never finished it, either.",
      "Tanah Abang, Jakarta",
      "February 2024"
    ),
    make(
      "1488161628813-04466f872be2",
      "Elder portrait, weathered hands held quietly in the lap",
      "portrait",
      "Pak Suryo, at Rest",
      "Sixty-three years tending the same warung in Kemang. He says the city sounds louder than it used to, but the morning still smells the same.",
      "Kemang, South Jakarta",
      "March 2024"
    ),
    make(
      "1666902715814-691194b2f45f",
      "Young woman pausing on her motorbike at the crossroads",
      "tall",
      "Sari Between Errands",
      "She stops mid-errand to answer her sister on speakerphone. Behind her the lights change three times before she pulls away.",
      "Senopati, Jakarta",
      "June 2024"
    ),
    make(
      "1662962913155-9e6548038a43",
      "Documentary portrait of a worker between shifts",
      "portrait",
      "Between Shifts",
      "Six minutes of break, a glass of iced tea, a window that doesn't quite open. He gave me one minute and then went back inside.",
      "Pluit, North Jakarta",
      "April 2024"
    ),
    make(
      "1672132586348-7ecf47fe9208",
      "Generations together — quiet domestic portrait",
      "landscape4",
      "Three Chairs, One Room",
      "Grandmother, mother, daughter. Three generations who have learned to listen to each other without looking up.",
      "Bandung, West Java",
      "January 2024"
    ),
    make(
      "1639051019068-dd9bb332407a",
      "Closely observed portrait in natural window light",
      "portrait",
      "Window Light, 4 p.m.",
      "Afternoon light in this room arrives sideways for about eleven minutes. She gives me four of them and goes back to work.",
      "Bogor, West Java",
      "May 2024"
    ),
    make(
      "1733094444090-b0e219770d1c",
      "A stranger looks up — the small acknowledgment of being seen",
      "tall",
      "Caught Looking",
      "The frame I almost didn't take, because she looked up at the wrong moment. Then I realised: that was the picture.",
      "Yogyakarta",
      "July 2024"
    ),
    make(
      "1500648767791-00dcc994a43e",
      "Worker resting at the end of a long shift",
      "portrait",
      "End of Shift",
      "Twelve hours on his feet. He sat down for the first time at 9:42 p.m. I waited until 9:43.",
      "Tanjung Priok port",
      "August 2024"
    ),
    make(
      "1531123897727-8f129e1688ce",
      "Young woman laughing in available light",
      "portrait",
      "The Laugh That Made the Frame",
      "Her friend off-camera said something I will never know. I am grateful to that friend.",
      "Kemang, Jakarta",
      "September 2024"
    ),
    make(
      "1531746020798-e6953c6e8e04",
      "Schoolgirl looking out a bus window",
      "tall",
      "Friday on the Bus",
      "She rides this route four days a week. On Fridays she has the seat by the window. On Fridays I get the picture.",
      "TransJakarta, Corridor 1",
      "October 2024"
    ),
    make(
      "1564564321837-a57b7070ac4f",
      "Grandmother weaving in an open doorway",
      "portrait",
      "Bu Ratna's Doorway",
      "Bu Ratna has woven in this doorway since 1986. She lets in the light, the cats, and — once a week — me.",
      "Solo, Central Java",
      "November 2023"
    ),
  ];

  const LANDSCAPE = [
    make(
      "1587651687979-77cf05d1b841",
      "Volcanic ridge rising above a sea of low cloud",
      "landscape",
      "Bromo, Before the Crowd",
      "The viewing platform fills at 4:30. If you arrive at 3:50, you have the ridge to yourself, and the volcano remembers you better.",
      "Mount Bromo, East Java",
      "August 2023"
    ),
    make(
      "1597553716923-45474a48fbe4",
      "Tall mountain wrapped in passing cloud at first light",
      "tall",
      "Semeru Lifts Her Veil",
      "Three days of waiting, two days of fog. On the morning of the third the mountain finally agreed to be photographed.",
      "Mount Semeru, East Java",
      "August 2023"
    ),
    make(
      "1699302150582-bffc5309a8c8",
      "Green highland slopes under drifting white cloud",
      "landscape4",
      "Dieng, After the Rain",
      "The plateau holds rain like a sponge. The next morning the whole valley smells of wet grass and woodsmoke.",
      "Dieng Plateau, Central Java",
      "October 2023"
    ),
    make(
      "1723407877285-584e2d0053ab",
      "Quiet plateau and distant peaks at dawn",
      "landscape",
      "Plateau, 5:14 a.m.",
      "The first colour comes up behind the far ridge — not orange, not pink, the impossible third colour you only see once a day.",
      "Ranu Kumbolo, East Java",
      "June 2023"
    ),
    make(
      "1588522621257-23648044339e",
      "Hand-built houses on the foot of a volcano",
      "landscape4",
      "Village at the Foot",
      "Forty-two households live within the volcano's evacuation radius. They have a phrase for it: \"the mountain knows our roof.\"",
      "Cemoro Lawang, East Java",
      "August 2023"
    ),
    make(
      "1589648409377-21889dbd786f",
      "A plume of smoke rises from a crater on the horizon",
      "landscape",
      "Plume",
      "She breathes out about every nine minutes — quiet, white, deliberate. The locals time their tea by it.",
      "Mount Bromo, East Java",
      "August 2023"
    ),
    make(
      "1616584743376-bb191d6ee719",
      "Mountain road switching back into the highlands",
      "portrait",
      "The Road to Tetebatu",
      "Twenty-seven switchbacks, two flat tyres, one breakdown, one cup of coffee at the top that I will remember forever.",
      "Lombok",
      "April 2024"
    ),
    make(
      "1698444333435-421f0b85634b",
      "Ridges layered into haze — quiet morning panorama",
      "pano",
      "Layered Ridges",
      "Five ridges, five shades of blue. The further out you look, the more the world simplifies itself.",
      "Mount Argopuro, East Java",
      "July 2023"
    ),
    make(
      "1485206412256-701ccc5b93ca",
      "Volcanic cone wrapped in cool mist",
      "landscape",
      "Mist Like Patience",
      "The mist sits on this cone for hours at a time. You don't photograph it — you wait for it to move, and then it photographs you.",
      "Rinjani caldera, Lombok",
      "May 2024"
    ),
    make(
      "1418065460487-3e41a6c84dc5",
      "Volcanic plain glowing with sunrise color",
      "landscape",
      "The Plain, Glowing",
      "Five minutes of true colour before the sun gets too high. After that, it is just another desert.",
      "Mount Bromo sea of sand",
      "August 2023"
    ),
    make(
      "1454496522488-7a8e488e8606",
      "Misted forest floor in cool morning light",
      "landscape4",
      "Forest Floor",
      "We walked into the cloud and out of it three times in twenty minutes. The forest seemed to breathe with us.",
      "West Bali National Park",
      "February 2024"
    ),
    make(
      "1470770841072-f978cf4d019e",
      "Calm lake reflecting a mountain at first light",
      "pano",
      "The Lake Holds Still",
      "The lake holds still for about eleven minutes a day. If you are lucky and quiet, you get the mountain twice.",
      "Lake Toba, North Sumatra",
      "March 2024"
    ),
  ];

  const OUTDOOR = [
    make(
      "1502082553048-f009c37129b9",
      "Runner threading a single track through alpine meadow",
      "landscape",
      "Single Track, Single Runner",
      "He runs this loop three mornings a week. I have followed him for two of them. He has yet to ask me why.",
      "Ranca Upas, West Java",
      "September 2024"
    ),
    make(
      "1464822759023-fed622ff2c3b",
      "Hiker silhouetted on the ridge as cloud rolls in",
      "landscape",
      "On the Ridge",
      "Eight minutes from the summit and the cloud started rolling up the valley behind him. He stopped walking. So did I.",
      "Mount Lawu, Central Java",
      "July 2023"
    ),
    make(
      "1469474968028-56623f02e42e",
      "A lone tree set against rolling mountains",
      "landscape",
      "The Tree That Stayed",
      "Everything around it has been logged and replanted twice. Nobody quite remembers why this one tree was left alone.",
      "Highlands, West Java",
      "May 2024"
    ),
    make(
      "1506905925346-21bda4d32df4",
      "Mountain ridge above a sea of low cloud at sunrise",
      "landscape",
      "Sea of Cloud",
      "The cloud doesn't lift — it gets thinner, until one minute you can see the village down there and the next it's gone again.",
      "Mount Prau, Central Java",
      "June 2023"
    ),
    make(
      "1530541930197-ff16ac917b0e",
      "Hiker glassing the valley from a high pass",
      "portrait",
      "Looking, Not Walking",
      "Half of what a guide does is look. The other half is decide not to walk yet.",
      "Mount Rinjani, Lombok",
      "May 2024"
    ),
    make(
      "1551632811-561732d1e306",
      "Lit tent on a still ridge under emerging stars",
      "landscape4",
      "Tent, Stars Coming In",
      "A 30-second exposure at ISO 1600. The headlamp inside the tent was me looking for a spare battery.",
      "Mount Slamet, Central Java",
      "August 2024"
    ),
    make(
      "1517524008697-84bbe3c3fd98",
      "Climber on a granite face in afternoon sun",
      "tall",
      "Granite, 3 p.m.",
      "The sun comes around this face at exactly 3 p.m. and stays for forty minutes. He times the whole pitch around it.",
      "Citatah cliffs, West Java",
      "March 2024"
    ),
    make(
      "1486325212027-8081e485255e",
      "Switchback descent through volcanic scree",
      "landscape",
      "Down the Scree",
      "Going up is for the lungs. Going down is for the knees. Going down on scree is for both, plus a little prayer.",
      "Mount Merapi, Central Java",
      "July 2024"
    ),
    make(
      "1455156218388-5e61b526818b",
      "Kayaker pushing across a glassy bay",
      "portrait",
      "Glassy Bay",
      "First paddle of the morning is always the loudest — it breaks something the night has spent eight hours setting up.",
      "Karimunjawa, Central Java",
      "April 2024"
    ),
    make(
      "1472214103451-9374bd1c798e",
      "Mountain road climbing into the highlands",
      "tall",
      "Up to Lembang",
      "An hour and a half of switchbacks, two coffee stops, one motorbike that overtook us seven times. The road is the point.",
      "Lembang, West Java",
      "September 2024"
    ),
    make(
      "1500382017468-9049fed747ef",
      "Field of grass bowing in evening wind",
      "landscape",
      "The Grass Goes First",
      "You hear the wind in the grass about ten seconds before you feel it on your face. There is a small lesson in that.",
      "Ijen plateau, East Java",
      "August 2023"
    ),
    make(
      "1473773508845-188df298d2d1",
      "Two travelers on a coastal road at golden hour",
      "landscape4",
      "Two on the Coast Road",
      "They had been driving for nine hours and had four left. They pulled over for this view and stayed for the whole sun.",
      "South coast, Java",
      "April 2024"
    ),
  ];

  window.PORTFOLIO_DATA = {
    street: {
      slug: "street",
      title: "Street",
      lead: "Honest, unscripted scenes from Indonesian streets — where light, noise, and humanity collide.",
      cover: "1659608927883-dc6d6f40ac1a",
      next: { slug: "human-interest", title: "Human Interest" },
      prev: { slug: "outdoor", title: "Outdoor" },
      items: STREET,
    },
    "human-interest": {
      slug: "human-interest",
      title: "Human Interest",
      lead: "The quiet portraits, the small gestures, the dignity of strangers — the work of remembering people as people.",
      cover: "1518725522904-4b3939358342",
      next: { slug: "landscape", title: "Landscape" },
      prev: { slug: "street", title: "Street" },
      items: HUMAN,
    },
    landscape: {
      slug: "landscape",
      title: "Landscape",
      lead: "Volcanoes, ridges, fog, and coastline — the Indonesian land at the hour when it speaks most clearly.",
      cover: "1587651687979-77cf05d1b841",
      next: { slug: "outdoor", title: "Outdoor" },
      prev: { slug: "human-interest", title: "Human Interest" },
      items: LANDSCAPE,
    },
    outdoor: {
      slug: "outdoor",
      title: "Outdoor",
      lead: "Travel, expedition, and adventure — life lived under open sky, captured between the planning and the rest.",
      cover: "1502082553048-f009c37129b9",
      next: { slug: "street", title: "Street" },
      prev: { slug: "landscape", title: "Landscape" },
      items: OUTDOOR,
    },
  };
})();
