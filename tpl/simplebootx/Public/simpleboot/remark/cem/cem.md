name: inverse
layout: true
class: center, middle, inverse
---
name: cover
#A Novel Automatic Tongue Image Segmentation Algorithm: Color Enhancement Method Based on L\*a\*b\* Color Space
##**Li Chen**, Dongyi Wang, Yiqin Liu, Xiaohang Gao, Huiliang Shang\*
[Bioinformatics and Biomedicine (BIBM), 2015 IEEE International Conference on , pp.990-993, 9-12 Nov. 2015]
.footnote[ Go to [site](http://ieeexplore.ieee.org/xpl/articleDetails.jsp?arnumber=7359818) Use Up/Down Key to turn page.]

---
name: Problem
layout: false
# Problem
## separate tongue body from face skin and lip which have similar color
.div3[
]
.div6[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/precedure1.jpg "Tongue")
.center[Original Tongue picture]
]
---
name: Recent Studies
layout: false
.left-column[
  # Recent Studies 
]
.right-column[
  
##Focus on Complicated Active contour model (ACM) or Snake

- Polar edge detector[2]

- Watershed [3]

- General Gradient Vector Flow (GGVF)[4]

- Double Snake [5]

##Use usually one color space

- Fail to utilize advantage of other color spaces

]

---
name: Method
.left-column[
  # Our Method 
]
.right-column[

#CEM -- Color enhancement method

- In HSV space, using a hue threshold control function to determine a proper threshold value for preliminary separation of tongue region

- In RGB space, performing color enhancement to obtain a better luminance which is more suitable for tongue segmentation

- In L*A*B* space, using the luminance sensitivity of L channel to constrain the area of interest

]
  
---
name: Procedure
# Procedure
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/precedure1.jpg "Original")
.center[Original]
]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/precedure2.jpg "hue threshold control function")
.center[Hue threshold control function]
]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/precedure3.jpg "Select areas after CEM")
.center[Select areas after CEM]
]
.clearfix[
.center[ ]
]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/precedure4.jpg "Valid pixels in L*a*b* color space")
.center[Valid pixels in L*a*b* color space]
]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/precedure5.jpg "After open operation")
.center[After open operation]
]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/precedure6.jpg "Final")
.center[Final]
]

---
name:Effect
#CEM effect
.div12[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/lab_before.jpg "Lab before")
.center[Original L\\\*a\\\*b\\\* channels]
]
.div12[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/lab_after.jpg "Lab before")
.center[ L\\\*a\\\*b\\\* channels after CEM]
]
---
name:Examples
#Examples
.div2[]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/example1.jpg "example1")
]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/example2.jpg "example2")
]
.div2[]
.clearfix[
.center[ ]
]
.div2[]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/example3.jpg "example3")
]
.div4[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/cem/example4.jpg "example4")
]
.div2[]

---
name: Comparison
#Comparison with other method
.center[ Speed and accuracy.red[&#42;] between four algorithms ]
<table>
	<tr>
		<th>Algorithm</th><th>CEM-L*A*B*</th><th>watershed</th><th>Original snake</th><th>C2G2FSnake</th>
	</tr>
	<tr>
		<td>Speed (s)</td><td>0.630</td><td>1.65</td><td>4.01</td><td>11.46</td>
	</tr>
	<tr>
		<td>Quality (%)</td><td>98.9</td><td>89.0</td><td>73.4</td><td>98.4</td>
	</tr>
</table>


.footnote[
.red[&#42;] Tested in Matlab 2014a on Windows 8.1<br/>
Quality: Percent of contour region with wrong pixels according to the ideal contour picture
]

---
name: References
#Some References
- [1] W. Su, Z.-Y. Xu, Z.-Q. Wang, and J.-T. Xu, “Objectified study on tongue images of patients with lung cancer of different syndromes,” Chin. J. Integr. Med., vol. 17, no. 4, pp. 272–276, 2011.
- [2] Z. Wangmeng, W. Kuanquan, Z. David, Z. Hongzhi, Combination of Polar Edge Detection and Active Contour Model for Automated Tongue Segmentation, Third International Conference on Image and Graphics (ICIG’04), 2004, pp. 270-273.
- [3] J. Wu, Z. Yonghong, and B. Jing, Tongue Area Extraction in Tongue Diagnosis of Traditional Chinese Medicine, Engineering in Medicine and
Biology Society. 27th Annual International Conference of the, 2006, pp.4955-4957. 
- [4] F. Hongguang, W. Rongqiu Wu, and W. Weiming, Active Contour Model based on Dynamic Extern Force and Gradient Vector Flow, 2008 International onference on BioMedical Engineering and Informatics, 2008,vol. (1) pp. 863-867. 
- [5] Z. Xue-ming, L. Hangdong, and Z. Lizhong, Application of Image Segmentation Technique in Tongue Diagnosis, 2009 International Forum on Information Technology and Applications, 2009, vol. (2), pp. 768-771.


---
class: center, middle, inverse
#End