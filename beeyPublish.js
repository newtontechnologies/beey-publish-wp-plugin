import BeeyPublish from 'https://unpkg.com/@beey/publish@latest/dist/beey-publish.min.js';

// wordpress specific script here
console.log('beeyPublish script injected!!');
window.onload = () => {
let conts = document.getElementsByClassName("beey-publish-wp-container");
for(let i = 0; i < conts.length; i++) {
  activate(conts[i]);
}
}

async function activate(elem) {
  let params = JSON.parse(elem.getAttribute("params"))
  let randId = parseInt(Math.random() * 1e10)
  let container = document.querySelector('.wp-container-7');
  elem.id = randId

  const publish = new BeeyPublish(container, {
    transcript: {
      showParagraphButtons: params.showParagraphButtons ?? false,
      enablePhraseSeek: params.enablePhraseSeek ?? false,
      keepTrackWithMedia: params.keepTrackWithMedia ?? false,
    },
    media: {
      url: "/wp-content/beeyPublish/"+params.publish_id+"/media.mp4",
      showVideo: params.showVideo ?? true,
      showSpeakers: params.showSpeakers ?? false,
    },
      subtitlesUrl: "/wp-content/beeyPublish/"+params.publish_id+"/sub.vtt"
  })
  await publish.loadTrsx({
    url: "/wp-content/beeyPublish/"+params.publish_id+"/subs.trsx",
  });
}




