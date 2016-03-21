name: inverse
layout: true
class: center, middle, inverse
---
name: cover
#An Adaptive Computer-aided Tongue Diagnosis Method using Color-calibration Preprocessing and Multiple Feature Synthesis based on Android Platform
##Miao Wang, Li Chen, Qing Li, Dongyi Wang, Yiqin Liu, Yi Zhang, Shoulan Bing, Huiliang Shang\*
[International Journal of Wireless and Mobile Computing,Vol. 9, No. 3, pp.240–249]
.footnote[ Go to [Journal site](http://www.inderscience.com/info/inarticletoc.php?jcode=ijwmc&year=2015&vol=9&issue=3) Use Up/Down Key to turn page.]
---
name: Background
layout: false
# Background 
- According to Traditional Chinese Medicine (TCM), the tongue can reflect the condition of organs as well as the degree and progression of disease.

- The prevalence and capability of mobile phones offer an ideal platform for our tongue diagnosis system to be practiced.
---
name: Problem
layout: false
.left-column[
  # Problem 
]
.right-column[
- In traditional method of tongue diagnosis, doctors determine the syndrome mainly through **visual observation** and **subjective experience**.

- Quite a few computerized tongue diagnosis methods are quite **sensitive** to the quality of the initial tongue image. Camera bears the possibility of **distorting** the original colors of the images
]
---
name: Task
layout: false
.left-column[
  # What we do 
]
.right-column[
  
##An Android APP:

- Use QCGP to solve the problem of white balance

- Adapted HSV model in Tongue brim pixels searching

- Adapted inverted pentagonal four-line tongue outline searching and linking algorithm

- Accuracy and effectiveness corroborated with professional clinicians

]

---
name: QCGP
layout: false

  # QCGP(Quadratic Combining GW&PR) 

- Grey World Method:

	K =（R<SUB>avg</SUB>+G<SUB>avg</SUB>+B<SUB>avg</SUB>)/3,

	R<SUB>new</SUB> = (R*K)/R<SUB>avg</SUB>
	
	assuming a certain standard spatial spectral average exists

- Perfect Reflector Method:
	
	R<SUB>new</SUB> = R*255/R<SUB>AvgTop10%</SUB>

- Quadratic combining two balance algorithms: 

	u<SUP>r</SUP>R<SUP>2</SUP><SUB>avg</SUB>+v<SUP>r</SUP>R<SUB>avg</SUB> = K<SUB>avg</SUB>

	u<SUP>r</SUP>R<SUP>2</SUP><SUB>max</SUB>+v<SUP>r</SUP>R<SUB>max</SUB> = K<SUB>max</SUB>
  
---
name: White_Balance
# White Balance
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/initial_tongue_image.jpg "initial tongue image")
.center[initial tongue image]
]
.div4[]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/after_color_calibration.jpg "Tongue image after color calibration")
.center[Tongue image after color calibration]
]
---
name:procedure
#Procedure after color calibration
.div2[]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/brim_edges.jpg "Tongue brim edges")
.center[Tongue brim edges]
]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/edges_image.jpg "Tongue edges image")
.center[Tongue edges image]
]
.div2[]
.clearfix[
.center[ ]
]
.div2[]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/General_brim_image.jpg "General tongue brim image")
.center[General tongue brim image]
]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/outline_image.jpg "Tongue outline image")
.center[Tongue outline image]
]
.div2[]
---
name: extraction
layout: false
.left-column[
  # Tongue feature extraction 
]
.right-column[
  
##Parameters:

- thickness of tongue coating: the ratio of the number of tongue coating pixels(a hue range near yellow) to that of total pixels

- average hue of tongue blade pixels: average hue within a hue range near red and also not excessively big in value

- humidity of the tongue: the ratio of pixels with excessively big values to that of total pixels 

- crackle flaws: the ratio of edges pixels in edge image to that of total pixels

]
---
name: Result
layout: false
  # Test Result
.div3[
  ![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/within_white_outline.jpg "within white outline")
	.center[Tongue area within white outline]
]
.div3[
	![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/Classification.jpg "Classification and diagnosis")
		.center[Classification and diagnosis]
]
.div6[
	Tongue is in light red with thin white coating which is normal and healthy. The clinical features suggest that the patient is in good health and more care is needed to maintain the present physical condition.
]
.clearfix[
.center[ ]
]
.div2[]
.div8[
	.center[Statistics of the main feature of the tongue image
	<table>
		<tr>
			<th>Feature</th><th>thickness</th><th>Crack</th><th>Humidity</th>
		</tr>
		<tr>
			<th>Value</th><td>0.1684</td><td>0.0584</td><td>0.0976</td>
		</tr>
	</table>
	]
]
.div2[]
	
	
---
name: cases1
# Some unhealthy cases
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/case_image2.jpg "case image2")
]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/case_app2.jpg "case app2")
]
.div4[
	-Diagnosis: Pale tongue, deficiency of vital energy and blood
	-Recommendation: Slow in motion, maintain your energy and life routines, keep good hours. Besides eating more warming foods, such as beef, mutton, shrimp, loach, eel etc., the clients can use Fu Yang tank to dredge the acupuncture points in needle warming moxibustion, involving energy pass, vital points, kidney shu, to relieve symptoms.
]
---
name: cases2
# Some unhealthy cases
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/case_image1.jpg "case image1")
]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/whitebalance/case_app1.jpg "case app1")
]
.div4[
	-Diagnosis: Fresh red tongue with fever and irritability
	-Recommendation: Abstaining from cold medicine, bloodletting treats and pathogenic heat scatters, clients should also avoid warming treats which generate afterheat recidivation. Besides not having hot rice or acidic gruel, cool water, fresh vension, you’d better seek medical advice. Aimed clients are recommended not to inhibit the consumption of dog meat, mutton etc.
]
---
class: center, middle, inverse
#End