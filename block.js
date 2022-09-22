wp.blocks.registerBlockType('beey-publish/basic', {
  title: 'BeeyPublish',
  icon: 'smiley',
  category: 'common',
  attributes: {
    publish_id: {type: 'string'},
    showVideo: {type: 'boolean'},
    enablePhraseSeek: {type: 'boolean'},
    keepTrackWithMedia: {type: 'boolean'},
    showSpeakers: {type: 'boolean'},
    showParagraphButtons: {type: 'boolean'},
  },
  
  edit: function(props) {
    return React.createElement(
      "div",
      { style: { border: "1px solid black", padding: "1em" }},
      	React.createElement(
      	  "b",
      	  null,
      	  "Beey Publish"
      	),
      	React.createElement("br"),
      	React.createElement("input", { type: "text", placeholder: "ID nahrávky z administrace", value: props.attributes.publish_id, onChange: (e) => {props.setAttributes({publish_id: e.target.value})} }),
      	React.createElement("br"),
      	React.createElement("input", { type: "checkbox", checked: props.attributes.showVideo, onChange: (e) => {props.setAttributes({showVideo: !props.attributes.showVideo})} }),
      	React.createElement("label", {},"Zobrazit video"),
      	React.createElement("br"),
      	React.createElement("input", { type: "checkbox", checked: props.attributes.enablePhraseSeek, onChange: (e) => {props.setAttributes({enablePhraseSeek: !props.attributes.enablePhraseSeek})} }),
      	React.createElement("label", {},"Povolit přehrávání od konkrétního slova kliknutím v textu"),
      	React.createElement("br"),
      	React.createElement("input", { type: "checkbox", checked: props.attributes.keepTrackWithMedia, onChange: (e) => {props.setAttributes({keepTrackWithMedia: !props.attributes.keepTrackWithMedia})} }),
      	React.createElement("label", {},"Zapnout zvýrazňování přehraných slov"),
      	React.createElement("br"),
      	React.createElement("input", { type: "checkbox", checked: props.attributes.showSpeakers, onChange: (e) => {props.setAttributes({showSpeakers: !props.attributes.showSpeakers})} }),
      	React.createElement("label", {},"Zobrazit mluvčí"),
      	React.createElement("br"),
      	React.createElement("input", { type: "checkbox", checked: props.attributes.showParagraphButtons, onChange: (e) => {props.setAttributes({showParagraphButtons: !props.attributes.showParagraphButtons})} }),
      	React.createElement("label", {},"Zobrazit tlačítka u odstavců"),
	)
  },
  save: function(props) {
    return wp.element.createElement(
      "div",
      { style: { border: "none" }, class: "beey-publish-wp-container", params: JSON.stringify(props.attributes) },
      "",
    );
  }
})
