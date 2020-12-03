import { CKEditor } from '@ckeditor/ckeditor5-react';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import React, { useState } from "react"
import RichTextEditor from "react-rte"
//import { parseXML } from 'jquery';
import ReactHtmlParser from 'react-html-parser';

export function TextEditor(props) {
  const [text, setText] = useState("")
  return (
    <div className="App">
          <CKEditor
          className="textEditor"
            editor={ClassicEditor}
            data={text}
            onChange={(e, editor) => {
                const data = editor.getData()
                setText(data)
              }
            }
           />
      <div>
        {/*<p>{ ReactHtmlParser(text)}</p>*/}
        <button className="btn btn-warning" onClick={()=>props.addComment(text)}>Comment</button>
      </div>
    </div>
  )
}


