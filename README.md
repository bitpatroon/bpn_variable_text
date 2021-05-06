# bpn_variable_text

Allows to create variable texts in the system with a label.

## Usage

### Code

Call static:
`\BPN\BpnVariableText\Service\TextService::getTextByLabelName().`

### ViewHelper

* Will retrieve the text for `label_example` and
* replace ###label1### to 'test' and ###label2### into 'content 1' in the label_example record and return the output

Declare by adding to html tag in Fluid view

```
<html ....
      xmlns:sl="http://typo3.org/ns/BPN/BpnVariableText/ViewHelpers"
      ....
>
```

Add to your template or partial:

```
<sl:variableText labelName="label_example" markers="{label1: '[[test]]'}">
    <sl:variableText.marker name="label2">content 1</sl:variableText.marker>
</sl:variableText>
 ```

Suppose `label_example` is:

_Lorem ipsum dolor sit amet, consectetur adipiscing elit.
Morbi id porttitor dolor. Proin vel sodales nunc. Curabitur quis mauris
quis nisl faucibus pellentesque. Nunc quis ###label1### neque sit amet
felis convallis ###label2### faucibus vitae pellentesque ligula._

will be rendered

_Lorem ipsum dolor sit amet, consectetur adipiscing elit.
Morbi id porttitor dolor. Proin vel sodales nunc. Curabitur quis mauris
quis nisl faucibus pellentesque. Nunc quis [[test]] neque sit amet
felis convallis content 1 faucibus vitae pellentesque ligula._


## Thanks to
Frans van der Veen.
<br/>May the force be with you!

Ported to TYPO3 10.4 by Sjoerd Zonneveld
