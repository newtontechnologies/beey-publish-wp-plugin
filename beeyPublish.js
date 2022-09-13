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
      showSpeakers: params.showSpeakers ?? false,
    },
    media: {
      url: 'https://www.beey.io/wp-content/uploads/2022/07/job-interview.mp4',
    },
  })
  console.log(publish)
  await publish.loadTrsx({
    url: 'https://www.beey.io/wp-content/uploads/2022/07/job-interview.trsx',
  });
}




