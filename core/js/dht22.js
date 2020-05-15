var sensorLib = require("node-dht-sensor");
 
var app = {
  sensors: [
    {
      name: "Indoor",
      type: 11,
      pin: 17
    },
    {
      name: "Outdoor",
      type: 22,
      pin: 4
    }
  ],
  read: function() {
    for (var sensor in this.sensors) {
      var readout = sensorLib.read(
        this.sensors[sensor].type,
        this.sensors[sensor].pin
      );
      console.log(
        `[${this.sensors[sensor].name}] ` +
          `temperature: ${readout.temperature.toFixed(1)}°C, ` +
          `humidity: ${readout.humidity.toFixed(1)}%`
      );
    }
    setTimeout(function() {
      app.read();
    }, 2000);
  }
};
 
app.read();