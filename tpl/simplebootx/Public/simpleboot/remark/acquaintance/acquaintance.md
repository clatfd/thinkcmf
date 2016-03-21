name: inverse
layout: true
class: center, middle, inverse
---
name: cover
#An Improved Acquaintance Immunization Strategy for Complex Network
##Li Chen, Dongyi Wang
[Journal of Theoretical Biology(SCI,IF:2.116),Volume 385, 21 November 2015, Pages 58-65]
.footnote[ Go to [Download](http://dx.doi.org/10.1016/j.jtbi.2015.07.037) Use Up/Down Key to turn page.]
---
name: Background
layout: false
# Classic immunization strategies 

## Random immunization strategy immunizes a node randomly
- High immunization threshold 

## Target immunization strategy immunizes a node with most neighbor nodes
- Based on global information 

## Acquaintance immunization strategy randomly chooses a node and randomly immunizes one of its neighbor nodes
- Blindness 

---
name: Task
layout: false
# Problem
  
##Existing improvements: 

a) existing improvements to acquaintance immunization(common neighbor, threaded-tree, double immunization)
- static and whole scale

b) determine local or time-varying importance ranking 
- fail to deploy the benefits of acquaintance immunization strategy

##Need an improved strategy which is more adaptive to most network topology and achieve a better balance between cost and effectiveness.

---
name: Our_method
layout: false

  # Our method

##Combining these two benefits
- acquaintance immunization (strong adaptability using little information)
- local and time-varying information (accuracy during immunization)

##Using NSI (Network structure index )


---
name: NSI
layout: false
#NSI
.div6[
##Procedure
- Mark layer number
- Find value and connectivity
- Calculate NSI to reflect  value of  nodes

![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/acquaintance/nsieq.jpg "NSI equation")
- e is the emphasis parameter, L is the possible damage through connections, T is layers


]
.div6[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/acquaintance/nsi.jpg "NSI")
]

---
name:simulation
#Simulation result
.div4[
##Effect
- protecting 14.895 more nodes 
- Rising slope decreased
]
.div8[
![img1](/thinkcmfx/tpl/simplebootx/Public/simpleboot/remark/acquaintance/simu.jpg "Application circumstance")
]
.clearfix[
.center[ ]
]
.center[The average number of 200 times simulations of infected node number during 100 immunization steps using In-depth Acquaintance Immunization strategy and Original one.]


---
name: more
layout: false
#More simulations
- GDTANG network with various connection possibilities

- Random graph with various scale

- Random graph with various wiring probabilities

- WS-Small World Model with various replacement probability 

- Scale free model with various exponent of the degree distribution

---
name: conclusion
layout: false
#Conclusion

- In GDTang and Scale-free network models, its performance is only second to target immunization

- In most random graph, it is even the best strategy

- In WS-Small World Model, it is not effective when network is highly regular

- in general, it has obvious advantage over the original acquaintance strategy (protects more nodes and control spread rate)

---
class: center, middle, inverse
#End